<?php

declare(strict_types=1);

namespace ToolkitApi;

use PDO;

final class PdoSupp
{
    /**
     * @var string
     */
    private $last_errorcode;

    /**
     * @var string
     */
    private $last_errormsg;
    /**
     * @var PDO
     */
    private $pdo;

    /**
     *
     * @todo should perhaps handle this method differently if $options are not passed
     *
     * @param string $database
     * @param string $user
     * @param string $password
     * @param array|null $options
     * @return bool|PDO
     */
    public function connect($database, $user, $password, $options = null)
    {
        if (!$options) {
            $this->setError();
            return false;
        }

        $conn = new PDO($database, $user, $password, $options);

        if (!$conn instanceof PDO) {
            $this->setError();
            return false;
        }

        return $conn;
    }

    /**
     * PdoSupp constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param PDO $conn
     */
    public function disconnect($conn)
    {
        if ($conn instanceof PDO) {
            $conn = null;
        }
    }

    /**
     * @param PDO|null $conn
     */
    protected function setError($conn = null)
    {
        if ($conn) {
            $this->setErrorCode($conn->errorCode());
            $this->setErrorMsg(implode('|', $conn->errorInfo()));
        } else {
            $this->setErrorCode($this->pdo->errorCode());
            $this->setErrorMsg(implode('|', $this->pdo->errorInfo()));
        }
    }

    /**
     * @param string $errorCode
     */
    protected function setErrorCode($errorCode)
    {
        $this->last_errorcode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->last_errorcode;
    }

    /**
     * @param string $errorMsg
     */
    protected function setErrorMsg($errorMsg)
    {
        $this->last_errormsg = $errorMsg;
    }

    /**
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->last_errormsg;
    }

    /**
     * this function used for special stored procedure call only
     *
     * @param PDO $conn
     * @param string $stmt
     * @param array $bindArray
     * @return string
     */
    public function execXMLStoredProcedure($conn, $stmt, $bindArray)
    {
        $statement = $conn->prepare($stmt);

        if (!$statement) {
            $this->setError($conn);
            return false;
        }

        $result = $statement->execute(array(
            $bindArray['internalKey'],
            $bindArray['controlKey'],
            $bindArray['inputXml']
        ));

        if (!$result) {
            $this->setError($conn);
            return "PDO error code: " . $this->pdo->errorCode() . ' msg: ' . $this->pdo->errorInfo();
        }

        $outputXml = '';

        if (!$bindArray['disconnect']) { // a disconnect request won't return data
            // Loop through rows, concatenating XML into a final XML string.
            foreach ($statement->fetchAll() as $row) {
                // for each row, get XML string from first and only array element, 
                // no matter whether assoc or numeric key
                $xmlChunk = reset($row); 
                if ($xmlChunk) {
                    // Remove any "garbage" from after ending </script> tag (there used to be an ODBC clob issue)
                    if (strstr($xmlChunk , "</script>")) {
                        $pos = strpos($xmlChunk, "</script>");
                        $pos += strlen("</script>"); 
                        $outputXml .= substr($xmlChunk, 0, $pos);
                        break;
                    } else {
                        $outputXml .= $xmlChunk;
                    }
                }
            }
        }

        return $outputXml;
    }

    /**
     * @param PDO $conn
     * @param string $stmt
     * @return array
     */
    public function executeQuery($conn, $stmt)
    {
        $txt = array();
        $statement = $conn->prepare($stmt);
        $result = $statement->execute();

        if (!$result) {
            $this->setError($conn);
            return $txt;
        }
        foreach ($statement->fetchAll() as $row) {
            $txt[] = $row;
        }

        return $txt;
    }
}
