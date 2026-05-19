<?php
// Handle CLI arguments
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    parse_str($argv[1], $_GET);
}

$db = new SQLite3(__DIR__ . '/../private/members.db');

if (!isset($_GET['id'])) {
    $result = $db->query("SELECT * FROM members");
    echo "<!DOCTYPE html>
<html>
<head>
    <title>Group Bulletin Board</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; }
        h1 { color: #333; }
        ul { list-style: none; padding: 0; }
        li { margin: 10px 0; }
        a { text-decoration: none; color: #0066cc; font-size: 18px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Group qwerty - Member List</h1>
    <ul>";
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo "<li><a href='member.php?id={$row['id']}'>{$row['name']}</a></li>";
    }
    echo "    </ul>
</body>
</html>";
} else {
    $id = (int)$_GET['id'];
    $stmt = $db->prepare("SELECT * FROM members WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    if (!$row) {
        echo "<h1>Member not found</h1>";
        exit;
    }

    echo "<!DOCTYPE html>
<html>
<head>
    <title>{$row['name']}</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        td:first-child { font-weight: bold; width: 140px; }
        a { color: #0066cc; }
    </style>
</head>
<body>
    <h1>{$row['name']}</h1>
    <table>
        <tr><td>Student ID</td><td>{$row['student_id']}</td></tr>
        <tr><td>Email</td><td>{$row['email']}</td></tr>
        <tr><td>Role</td><td>{$row['role']}</td></tr>
        <tr><td>Major</td><td>{$row['major']}</td></tr>
    </table>
    <br><a href='member.php'>← Back to list</a>
</body>
</html>";
}
?>
