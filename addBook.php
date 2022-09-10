<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
</head>
<body>
<?php
// define variables and set to empty values
$titleErr = $authorErr = $published_dateErr = "";
$title = $author = $published_date = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (empty($_POST["title"])) {
$titleErr = "Judul Buku Harus Diisi!";
} else {
$title = test_input($_POST["title"]);
}
if (empty($_POST["author"])) {
$authorErr = "Penulis Buku Harus Diisi!";
} else {
$author = test_input($_POST["author"]);
// check if author only contains letters and whitespace
if (!preg_match("/^[a-zA-Z-' ]*$/",$author)) {
$authorErr = "Nama penulis tidak boleh mengandung angka dan simbol!";
}
}
if (empty($_POST["published_date"])) {
$published_dateErr = "Tanggal Terbit Harus Diisi!";
} else {
$published_date = test_input($_POST["published_date"]);
$parsed_date = date_parse($published_date);
// check if e-mail address is well-formed
if (!checkdate($parsed_date['month'], $parsed_date['day'],
$parsed_date['year'])) {
$published_dateErr = "Format tanggal terbit tidak valid!";
}
}
}
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
if ($titleErr || $authorErr || $published_dateErr) {
echo "<h2>Submisi buku gagal:</h2>";
echo $titleErr;
echo "<br>";
echo $authorErr;
echo "<br>";
echo $published_dateErr;
echo "<br>";
} else {
$servername = "localhost";
$username = "Diandra";
$password = "12345678";
$dbname = "library_db";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO book (title, author, published_date)
VALUES ('".$title."', '".$author."', '".$published_date."')";
if ($conn->query($sql) === TRUE) {
echo "New record created successfully";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
echo "<h2>Data Buku berhasil diinput:</h2>";
echo $title;
echo "<br>";
echo $author;
echo "<br>";
echo $published_date;
echo "<br>";
}
?>
</body>
</html>