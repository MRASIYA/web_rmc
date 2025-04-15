<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>RMC Counting </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fb;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* 3D effect for the title */
        h2 {
            color: #4CAF50;
            font-size: 3em;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
            text-transform: uppercase;
            font-weight: bold;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3), 0 0 25px #4CAF50, 0 0 5px #4CAF50;
            animation: 3DTextEffect 1.5s ease-in-out infinite alternate;
        }

        /* Animation to make text shine and pop */
        @keyframes 3DTextEffect {
            0% {
                text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3), 0 0 25px #4CAF50, 0 0 5px #4CAF50;
            }
            50% {
                text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.6), 0 0 30px #4CAF50, 0 0 10px #4CAF50;
            }
            100% {
                text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3), 0 0 25px #4CAF50, 0 0 5px #4CAF50;
            }
        }

        input[type="text"], input[type="number"], button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1.1em;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="number"]:focus, button:hover {
            border: 1px solid #4CAF50;
            box-shadow: 0 4px 10px rgba(0, 255, 0, 0.2);
        }

        button {
            background-color: #4CAF50;
            color: white;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
            font-size: 1.1em;
        }

        th {
            background-color: #f2f2f2;
        }

        td input {
            width: 80%;
        }

        /* For mobile responsiveness */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            h2 {
                font-size: 2em;
            }

            input[type="text"], input[type="number"], button {
                font-size: 1em;
            }

            table, th, td {
                font-size: 1em;
            }
        }

        /* 3D button effects */
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background: #4CAF50;
            color: white;
            font-size: 1.1em;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .button:active {
            transform: translateY(2px);
        }

        /* View saved data section */
        #savedEntries {
            display: none;
            margin-top: 20px;
        }
        /* Styled CSV download button */
.button {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px 0;
    background: #4CAF50;
    color: white;
    font-size: 1.1em;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.button:hover {
    background: #45a049;
    transform: translateY(-2px);
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
}

.button:active {
    transform: translateY(2px);
}

    </style>
</head>
<body>
    <div class="container">
        <h2>RMC Counting</h2>

        <!-- Input Fields -->
        <input type="text" id="name" placeholder="Enter Item Name">
        <input type="number" id="quantity" placeholder="Enter Quantity">
        <button type="button" onclick="addEntry()">Add</button>

        <!-- Save Form -->
        <form id="saveForm" action="save.php" method="POST" onsubmit="return prepareData()">
            <input type="hidden" name="data" id="dataInput">
            <button type="submit">Save</button>
        </form>

        <!-- View Saved Data Button -->
        <button class="button" onclick="toggleSavedData()">👁️ View Saved Entries</button>
        <!-- Button to download CSV -->
<button class="button" onclick="window.location.href='export_csv.php'">📥 Download CSV</button>


        <!-- Items to Save -->
        <h3>Items to Save:</h3>
        <table id="entryTable">
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
            </tr>
        </table>
        

        <!-- Already Saved Entries (Hidden by Default) -->
        <div id="savedEntries">
            <h3>Already Saved Entries:</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM entries ORDER BY id DESC");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <form method='POST' action='update.php'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <td><input type='text' name='name' value='{$row['name']}'></td>
                                <td><input type='number' name='quantity' value='{$row['quantity']}'></td>
                                <td>
                                    <button type='submit' name='update'>✏️ Update</button>
                                    <a href='delete.php?id={$row['id']}' onclick='return confirm(\"Delete this item?\")'>🗑️ Delete</a>
                                </td>
                            </form>
                        </tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        let entries = [];

        function addEntry() {
            const name = document.getElementById("name").value.trim();
            const quantity = document.getElementById("quantity").value.trim();

            if (!name || !quantity) {
                alert("Both fields are required.");
                return;
            }

            entries.push({ name, quantity: parseInt(quantity) });

            // Update the table with new entry
            const table = document.getElementById("entryTable");
            const newRow = table.insertRow();
            newRow.innerHTML = `<td>${name}</td><td>${quantity}</td>`;

            document.getElementById("name").value = "";
            document.getElementById("quantity").value = "";
        }

        function prepareData() {
            if (entries.length === 0) {
                alert("Add at least one item before saving.");
                return false;
            }

            document.getElementById("dataInput").value = JSON.stringify(entries);
            return true;
        }

        function toggleSavedData() {
            const section = document.getElementById('savedEntries');
            section.style.display = section.style.display === "none" ? "block" : "none";
        }
    </script>
</body>
</html>
