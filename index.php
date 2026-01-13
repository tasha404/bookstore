<!DOCTYPE html>
<html>
<head>
    <title>💜 Bookstore Input Form 💜</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: linear-gradient(to right, #fbeaff, #e0bbff);
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #6a0dad;
        }

        form {
            width: 85%;
            max-width: 900px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(106, 13, 173, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: linear-gradient(135deg, #b28dff, #d6a4ff);
            color: white;
            padding: 15px;
            font-size: 16px;
        }

        td {
            padding: 10px;
            border: 1px solid #e0bbff;
            background-color: #f9f0ff;
        }

        input[type="text"], input[type="number"] {
            width: 95%;
            padding: 8px;
            border-radius: 10px;
            border: 1px solid #d6a4ff;
            background-color: #fff6ff;
        }

        input[type="submit"], .add-btn {
            display: block;
            width: 230px;
            margin: 15px auto;
            padding: 12px;
            background: linear-gradient(to right, #a66cff, #b28dff);
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-btn:hover, input[type="submit"]:hover {
            background: linear-gradient(to right, #b28dff, #a66cff);
        }

        .summary-table {
            width: 85%;
            max-width: 900px;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff0ff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(106, 13, 173, 0.1);
        }

        .summary-table th {
            background-color: #9c6bff;
            color: white;
            padding: 15px;
        }

        .summary-table td {
            padding: 12px;
            border: 1px solid #f0e1ff;
            text-align: center;
        }

        .summary-table tr:last-child td {
            font-weight: bold;
            background-color: #f6ebff;
        }
    </style>
</head>
<body>
    <h2>📚 Cute Bookstore Entry Form 💫</h2>
    <form method="post">
        <table id="bookTable">
            <tr>
                <th>📖 Book Title</th>
                <th>💰 Price (RM)</th>
                <th>🔢 Quantity</th>
                <th>❌ Remove</th>
            </tr>
            <tr>
                <td><input type="text" name="title[]" required></td>
                <td><input type="number" name="price[]" step="0.01" min="0" required></td>
                <td><input type="number" name="qty[]" min="0" required></td>
                <td><button type="button" class="remove-btn" onclick="removeRow(this)">Remove</button></td>
            </tr>
        </table>
        <button type="button" class="add-btn" onclick="addRow()">➕ Add Another Book</button>
        <input type="submit" name="submit" value="🌟 View Summary 🌟">
    </form>

    <script>
        function addRow() {
            const table = document.getElementById("bookTable");
            const row = table.insertRow(-1);

            row.innerHTML = `
                <td><input type='text' name='title[]' required></td>
                <td><input type='number' name='price[]' step='0.01' min='0' required></td>
                <td><input type='number' name='qty[]' min='0' required></td>
                <td><button type='button' class='remove-btn' onclick='removeRow(this)'>Remove</button></td>
            `;
        }

        function removeRow(button) {
            const row = button.parentNode.parentNode;
            const table = document.getElementById("bookTable");
            if (table.rows.length > 2) {
                table.deleteRow(row.rowIndex);
            } else {
                alert("You must have at least one book entry.");
            }
        }
    </script>

    <?php
    if (isset($_POST['submit'])) {
        handleFormSubmission($_POST['title'], $_POST['price'], $_POST['qty']);
    }

    function handleFormSubmission($titles, $prices, $qtys) {
        echo "<h2>📊 Purchase Summary 📦</h2>";
        echo "<table class='summary-table'>";
        echo "<tr><th>📘 Book</th><th>🔢 Quantity</th><th>💵 Unit Price</th><th>📈 Subtotal</th></tr>";

        $grandSubtotal = 0;
        $totalBooks = array_sum($qtys);

        for ($i = 0; $i < count($titles); $i++) {
            if ($qtys[$i] > 0 && $prices[$i] >= 0) {
                $sub = calculateSubtotal($prices[$i], $qtys[$i]);
                $grandSubtotal += $sub;
                echo "<tr>
                        <td>" . htmlspecialchars($titles[$i]) . "</td>
                        <td>{$qtys[$i]}</td>
                        <td>" . formatCurrency($prices[$i]) . "</td>
                        <td>" . formatCurrency($sub) . "</td>
                      </tr>";
            }
        }

        $tax = calculateTax($grandSubtotal);
        $total = calculateTotal($grandSubtotal, $tax);

        echo "<tr><td colspan='3' align='right'>📦 Total Books:</td><td>{$totalBooks}</td></tr>";
        echo "<tr><td colspan='3' align='right'>📥 Subtotal:</td><td>" . formatCurrency($grandSubtotal) . "</td></tr>";
        echo "<tr><td colspan='3' align='right'>💸 Tax (6%):</td><td>" . formatCurrency($tax) . "</td></tr>";
        echo "<tr><td colspan='3' align='right'>🎉 Total:</td><td>" . formatCurrency($total) . "</td></tr>";
        echo "</table>";
    }

    function calculateSubtotal($price, $qty) {
        return $price * $qty;
    }

    function calculateTax($subtotal) {
        return $subtotal * 0.06;
    }

    function calculateTotal($subtotal, $tax) {
        return $subtotal + $tax;
    }

    function formatCurrency($amount) {
        return "RM " . number_format($amount, 2);
    }
    ?>
</body>
</html>
