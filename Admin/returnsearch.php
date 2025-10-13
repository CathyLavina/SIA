<?php
include 'db.php'; // make sure this connects to your database (lms_db)

$q = $_GET['q'] ?? '';

if (empty($q)) {
  echo json_encode([]);
  exit;
}

// Search for matching students (by ID number or name)
$sql = "
  SELECT 
    s.Student_ID AS student_id,
    s.Name AS name,
    s.School_ID_Number AS school_id,
    s.Course AS course,
    s.Year_Level AS year_level
  FROM Students s
  WHERE s.School_ID_Number LIKE '%$q%' OR s.Name LIKE '%$q%'
  LIMIT 10
";

$result = $conn->query($sql);

$students = [];

while ($row = $result->fetch_assoc()) {
  // Get borrowed books for each student
  $borrow_sql = "
    SELECT 
      b.Book_ID AS book_id,
      b.Title AS title,
      br.Borrow_Date AS borrow_date,
      br.Due_Date AS due_date,
      br.Status AS status
    FROM Borrow_Record br
    JOIN Book b ON br.Book_ID = b.Book_ID
    WHERE br.User_Type = 'student' AND br.User_ID = '{$row['student_id']}' AND br.Status = 'borrowed'
  ";

  $borrow_result = $conn->query($borrow_sql);
  $borrowed_books = [];

  while ($borrow_row = $borrow_result->fetch_assoc()) {
    $borrowed_books[] = $borrow_row;
  }

  $row['borrowed_books'] = $borrowed_books;
  $students[] = $row;
}

echo json_encode($students);
$conn->close();
?>