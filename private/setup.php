<?php
$db = new SQLite3(__DIR__ . '/members.db');

$db->exec("CREATE TABLE IF NOT EXISTS members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    student_id TEXT NOT NULL,
    email TEXT NOT NULL,
    role TEXT NOT NULL,
    major TEXT NOT NULL
)");

$db->exec("DELETE FROM members");

$members = [
    ['machi',  '413855643', '413855643@o365.tku.edu.tw', 'Group Lead', 'Computer Science and Information Engineering'],
    ['conan',  '413856138', '413856138@o365.tku.edu.tw', 'Member',     'Computer Science and Information Engineering'],
    ['russel', '413854729', '413854729@o365.tku.edu.tw', 'Member',     'Computer Science and Information Engineering'],
    ['kenny',  '413856161', '413856161@o365.tku.edu.tw', 'Member',     'Computer Science and Information Engineering'],
];

$stmt = $db->prepare("INSERT INTO members (name, student_id, email, role, major) VALUES (:name, :student_id, :email, :role, :major)");

foreach ($members as $m) {
    $stmt->bindValue(':name',       $m[0]);
    $stmt->bindValue(':student_id', $m[1]);
    $stmt->bindValue(':email',      $m[2]);
    $stmt->bindValue(':role',       $m[3]);
    $stmt->bindValue(':major',      $m[4]);
    $stmt->execute();
}

echo "Database setup complete\n";
?>
