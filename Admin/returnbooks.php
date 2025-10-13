<?php
include('header.php');
include('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Return Books</title>
  <link rel="stylesheet" href="returnbooks.css">
</head>
<body>

<main class="main-content">
  <h2 class="page-title">Return Books</h2>

  <div class="search-container">
    <input type="text" id="search" placeholder="Search by Student ID or Name...">
    <button id="clear-btn" class="clear-btn">&times;</button>
    <button id="search-btn">Search</button>
    <div class="suggestions" id="suggestions"></div>
  </div>

  <div class="result" id="result"></div>
</main>


  <script>
    const searchInput = document.getElementById('search');
    const searchBtn = document.getElementById('search-btn');
    const suggestionsBox = document.getElementById('suggestions');
    const resultBox = document.getElementById('result');

 // Fetch suggestions while typing
searchInput.addEventListener('keyup', (e) => {
  const query = searchInput.value.trim();

  // ⛔ Stop showing suggestions when pressing Enter
  if (e.key === 'Enter') {
    suggestionsBox.innerHTML = '';
    return;
  }

  if (query.length === 0) {
    suggestionsBox.innerHTML = '';
    return;
  }

  fetch(`returnsearch.php?q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(data => {
      suggestionsBox.innerHTML = '';
      data.forEach(item => {
        const div = document.createElement('div');
        div.textContent = `${item.student_id} - ${item.name}`;
        div.onclick = () => selectStudent(item);
        suggestionsBox.appendChild(div);
      });
    });
});


    // Search on Enter key
    searchInput.addEventListener('keydown', e => {
      if (e.key === 'Enter') {
        e.preventDefault();
        suggestionsBox.innerHTML = ''; // ✅ hide suggestions when pressing Enter

        searchStudent(searchInput.value);
      }
    });

    // Search on button click
    searchBtn.addEventListener('click', () => {
      suggestionsBox.innerHTML = ''; // ✅ hide suggestions when clicking Search

      searchStudent(searchInput.value);
    });

    function selectStudent(student) {
      searchInput.value = `${student.student_id} - ${student.name}`;
      suggestionsBox.innerHTML = '';
      showResult(student);
    }

    function searchStudent(query) {
      fetch(`returnsearch.php?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
          if (data.length > 0) {
            showResult(data[0]);
          } else {
            resultBox.innerHTML = '<p>No results found.</p>';
          }
        });
    }

    function showResult(student) {
      resultBox.innerHTML = `
        <div class="card">
          <h3>Student Information</h3>
          <p><strong>ID:</strong> ${student.student_id}</p>
          <p><strong>Name:</strong> ${student.name}</p>
        </div>
      `;
      showBorrowedBooks(student);

    }

    // ✅ ADD THIS BELOW showResult(student)
function showBorrowedBooks(student) {
  if (!student.borrowed_books || student.borrowed_books.length === 0) {
    resultBox.innerHTML += '<p>No borrowed books found for this student.</p>';
    return;
  }

  let html = `
    <div class="card">
      <h3>Borrowed Books</h3>
      <table border="1" cellpadding="6" cellspacing="0">
        <thead>
          <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Borrow Date</th>
            <th>Due Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
  `;

  student.borrowed_books.forEach(book => {
    html += `
      <tr>
        <td>${book.book_id}</td>
        <td>${book.title}</td>
        <td>${book.borrow_date}</td>
        <td>${book.due_date}</td>
        <td>${book.status}</td>
      </tr>
    `;
  });

  html += `
        </tbody>
      </table>
    </div>
  `;

  resultBox.innerHTML += html;
}


    /* ✅ Added clear (X) button logic — placed at the very end of your script */
    const clearBtn = document.getElementById('clear-btn');

    // Show or hide the clear button while typing
    searchInput.addEventListener('input', () => {
      clearBtn.style.display = searchInput.value ? 'block' : 'none';
    });

    // Clear input, suggestions, and results when clicked
    clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      clearBtn.style.display = 'none';
      searchInput.focus();

      suggestionsBox.innerHTML = '';
      resultBox.innerHTML = '';
    });
  </script>

</body>
</html>
