<!DOCTYPE html>
<html>
<body>

<h1>구매요청 페이지</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <input type="submit" name="submit" value="조회">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 조회 버튼이 눌렸을 때 실행할 코드
    showData();
}

function showData() {
    
    $host = '192.168.44.254';
    $user = 'mskang';
    $pw = '1234';
    $dbName = 'MES';
    $mysqli = new mysqli($host, $user, $password, $dNname);

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $pw);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL 쿼리
        $stmt = $conn->prepare("
            SELECT A.PR_NO, /*PR No.*/
          C.COM_CODE_NAME, /*상태*/
          B.PR_ITEM, /*자재(물품)내용
          A.PR_DATE, /*구매요청일*/
          D.USER_NAME , /*구매요청자*/
          A.PR_DELIVERY_DATE, /*납기일*/
          E.USER_NAME, /*구매담당자*/
          B.PR_ITEM_CC_URL /*참조URL*/
            FROM  PO_PR_MST AS A INNER JOIN PO_PR_DTL AS B
                                    ON  A.PR_NO     = B.PR_NO
                                LEFT OUTER JOIN PO_CM_CODE AS C
                                    ON  A.PR_STATUS_CODE = C.COM_CODE
                                    AND C.GROUP_COM_CODE = 'PR_STATUS'  
                                 LEFT OUTER JOIN PO_USER_MST AS D
                                    ON  A.PR_USER_ID = D.USER_ID
                                 LEFT OUTER JOIN PO_USER_MST AS E
                                    ON  A.PO_USER_ID = D.USER_ID
        ");
        $stmt->execute();

     
        echo "<table>";
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row['PR_NO'] . "</td>";
            echo "<td>" . $row['COM_CODE_NAME'] . "</td>";
            echo "<td>" . $row['PR_ITEM'] . "</td>";
            echo "<td>" . $row['CREATE_DTM'] . "</td>";
            echo "<td>" . $row['USER_NAME'] . "</td>";
            echo "<td>" . $row['PR_ITEM_CC_URL'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}
?>

</body>
</html>

