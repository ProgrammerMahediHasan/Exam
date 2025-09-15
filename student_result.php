<?php
class Student {
    public $id;
    public $name;
    public $batch;

    // Constructor
    public function __construct($id, $name, $batch) {
        $this->id = $id;
        $this->name = $name;
        $this->batch = $batch;
    }

    // Method to search and print result
    public function result($searchId) {
        $file = "results.txt"; // Must exist in the same folder

        if (!file_exists($file)) {
            echo "<div class='error'>Result file not found!</div>";
            return;
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            list($id, $marks) = explode(",", trim($line));
            if ($id == $searchId) {
                $grade = $this->calculateGrade((int)$marks);

                echo "
                <div class='result-box'>
                    <p><strong>Name:</strong> {$this->name}</p>
                    <p><strong>ID:</strong> {$this->id}</p>
                    <p><strong>Batch:</strong> {$this->batch}</p>
                    <p><strong>Marks:</strong> {$marks}</p>
                    <p><strong>Grade:</strong> {$grade}</p>
                </div>";
                return;
            }
        }

        echo "<div class='error'>No result found for ID: {$searchId}</div>";
    }

    // Grade calculation
    private function calculateGrade($marks) {
        if ($marks >= 80) return "A+";
        if ($marks >= 70) return "A";
        if ($marks >= 60) return "B";
        return "C";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 350px;
        }
        input[type="number"], input[type="text"] {
            width: 100%;
            padding: 6px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            background-color: #ddd;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #ccc;
        }
        .result-box {
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #000;
            font-weight: bold;
            width: 350px;
        }
        .error {
            font-weight: bold;
            margin-bottom: 15px;
        }

        h2{color: red;
        font-size: 25px;}

         #sub
         {background-color: green;
        font-weight: bold;}
    </style>
</head>
<body>

<h2>Check Result</h2>

<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $batch = $_POST['batch'];

    $student = new Student($id, $name, $batch);
    $student->result($id); // Result appears above the form
}
?>

<form method="post">
    Student ID: <input type="number" name="id" required>
    Name: <input type="text" name="name" required>
    Batch: <input type="text" name="batch" required>
    <input type="submit" name="submit" value="Show Result" id="sub">
</form>

</body>
</html>
