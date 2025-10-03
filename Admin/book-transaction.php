
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- FAVICON -->
  <link rel="shortcut icon" href="/img/loa_logo.png" type="image/x-icon">
  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
  <!-- ADMIN CSS -->
  <link rel="stylesheet" href="admin.css">

    <title>BOOK TRANSACTION</title>
    <style>
    .main-header {
      margin-top: 0px;
      background-color: #e9eef6;
      text-align: center;
      padding: 30px;
      font-weight: bold;
      margin-bottom: 15px;
      font-size: 1.5rem;
    }
    .transaction-container{
      margin-left: 300px;
    }
    
    body {
      background-color: #F4F7FB;
    }

    /* Book Transaction Page */
    .bg-white {
      background: #fff !important;
    }

    .table thead {
      background-color: #EDF0F6 !important;
    }

    .table th {
      font-size: 1rem;
      font-weight: 700 !important;
      color: #232D3F !important;
      white-space: nowrap;
    }

    .table td {
      font-size: .95rem;
      color: #232D3F;
      vertical-align: middle;
    }

    .table-responsive {
      min-height: 350px;
      overflow-x:auto;
    }

    input[disabled] {
      background: #EDF0F6 !important;
      color: #232D3F;
      font-weight: 500;
    }

    .btn-outline-secondary {
      border-radius: 8px;
    }

    .form-select {
      border-radius: 8px;
    }

    /* Responsive tweaks */
    @media (max-width: 991px) {
      .bg-white {
        padding: 1rem !important;
      }
      .table th, .table td {
        font-size: .9rem;
      }
    }
  </style>
</head>

<body>
<?php
include 'header.php'
?>

  <!-- SIDEBAR -->
   <?php
   include 'sidebar.php'
   ?>
  <div id="sidebar-container"></div>


  <div class="main-header">BOOK TRANSACTION</div>
  <div class="container m-auto">
    <div class="row">
      <div class="col-md-10 p-0 b-book">

    <!--MAIN CONTENT HERE-->
<!-- MAIN CONTENT: BOOK TRANSACTION -->
<div class="container-fluid px-4 py-5" style="background-color: #F4F7FB; min-height:100vh;">
  <div class="d-flex justify-content-center transaction-container">
    <div class="col-12 col-lg-10">

      <!-- Card Container -->
      <div class="bg-white rounded-3 p-4 shadow-sm">
        <div class="row g-3 align-items-end mb-4">
          <div class="col-12 col-sm-6 col-md-4">
            <label for="schoolId" class="form-label fw-semibold mb-1">SCHOOL ID NO.</label>
            <input type="text" class="form-control w-100" id="schoolId" placeholder="2022-1234-56" disabled>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label fw-semibold mb-1">&nbsp;</label>
            <button class="btn btn-outline-secondary w-100" id="sortByDate">
              <i class="fa-regular fa-calendar-days me-2"></i> SORT BY DATE
            </button>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <label for="requestType" class="form-label fw-semibold mb-1">REQUEST TYPE</label>
            <select class="form-select w-100" id="requestType">
              <option value="all">All</option>
              <option value="borrow">Borrow</option>
              <option value="return">Return</option>
            </select>
          </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-borderless align-middle mb-0" id="transactionTable">
            <thead style="background-color: #EDF0F6;">
              <tr class="fw-bold" style="color:#232D3F;">
                <th>SCHOOL ID</th>
                <th>BOOK TITLE</th>
                <th>TRANSACTION</th>
                <th>DATE OF TRANSACTION</th>
                <th>FINE FOR OVERDUE BOOKS</th>
              </tr>
            </thead>
            <tbody>
              <!-- Table rows rendered by JS -->
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>




<script>
    // Demo data for transactions
    const transactions = [
      {
        schoolId: "2022-1234-56",
        bookTitle: "Mathematics 101",
        transaction: "borrow",
        date: "09/01/2025",
        fine: "0.00 php"
      },
      {
        schoolId: "2022-1234-56",
        bookTitle: "Science 101",
        transaction: "return",
        date: "09/05/2025",
        fine: "0.00 php"
      },
      {
        schoolId: "2022-1234-56",
        bookTitle: "Physics 201",
        transaction: "borrow",
        date: "09/10/2025",
        fine: "0.00 php"
      },
      {
        schoolId: "2022-1234-56",
        bookTitle: "Biology 101",
        transaction: "return",
        date: "09/14/2025",
        fine: "0.00 php"
      },
      {
        schoolId: "2022-1234-56",
        bookTitle: "History 101",
        transaction: "borrow",
        date: "09/17/2025",
        fine: "0.00 php"
      },
      {
        schoolId: "2022-1234-56",
        bookTitle: "English 101",
        transaction: "return",
        date: "09/20/2025",
        fine: "0.00 php"
      }
    ];

    // Render table based on filter
    function renderTable(type = "all") {
      const tbody = document.querySelector("#transactionTable tbody");
      tbody.innerHTML = "";

      transactions.forEach(tx => {
        if (type === "all" || tx.transaction === type) {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${tx.schoolId}</td>
            <td>${tx.bookTitle}</td>
            <td class="text-uppercase">${tx.transaction}</td>
            <td>${tx.date}</td>
            <td>${tx.fine}</td>
          `;
          tbody.appendChild(tr);
        }
      });
    }

    // Request type filter
    document.getElementById('requestType').addEventListener('change', function() {
      renderTable(this.value);
    });

    // Stub for sort by date button
    document.getElementById('sortByDate').addEventListener('click', function() {
      // Simple sort by date descending for demo
      transactions.sort((a, b) => new Date(b.date) - new Date(a.date));
      renderTable(document.getElementById('requestType').value);
    });

    // Initial render
    renderTable();
  </script>

  </body>
</html>