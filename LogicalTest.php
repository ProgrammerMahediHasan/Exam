<?php
// ---------------- Interface ----------------
interface ILogicalTest {
    static function factorial($number);
    static function IsPrime($number);
    static function MinMax($numbers); 
    static function Result($number); 
    static function Uploadfile($file); 
    static function student_result($id);
}

// ---------------- LogicalTest Class ----------------
class LogicalTest implements ILogicalTest {

    // Factorial
    static function factorial($number) {
        if ($number < 0) return "Invalid number";
        $result = 1;
        for ($i = 1; $i <= $number; $i++) {
            $result *= $i;
        }
        return $result;
    }

    // Prime check
    static function IsPrime($number) {
        if ($number < 2) return false;
        for ($i = 2; $i <= sqrt($number); $i++) { 
            if ($number % $i == 0) return false;
        }
        return true;
    }

    // Min & Max
    static function MinMax($numbers) {
        if (!is_array($numbers) || empty($numbers)) return ["min" => null, "max" => null];

        $min = $numbers[0];
        $max = $numbers[0];

        foreach ($numbers as $num) {
            if ($num < $min) $min = $num;
            if ($num > $max) $max = $num;
        }

        return ["min" => $min, "max" => $max];
    }

    // Result / Grade
    static function Result($marks) {
        if ($marks >= 80 && $marks <= 100) return 'A+';
        if ($marks >= 70 && $marks < 80) return 'A';
        if ($marks >= 60 && $marks < 70) return 'B';
        if ($marks >= 0 && $marks < 60) return 'C';
        return 'Invalid Number';
    }

    // Upload file
    static function Uploadfile($file) {
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $file['tmp_name'];
            $fileName = $file['name'];
            $uploadDir = __DIR__ . '/uploads/';

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $destPath = $uploadDir . $fileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                return "File uploaded successfully: $fileName";
            } else {
                return "Error uploading file.";
            }
        }
        return "No file uploaded or upload error.";
    }

    // Student result search by ID
    static function student_result($id) {
        $filename = "results.txt"; // must exist in same folder
        if (!file_exists($filename)) return "Result file not found!";

        $file = fopen($filename, "r");
        $found = false;

        while (($line = fgets($file)) !== false) {
            $data = explode(",", trim($line)); // Format: id, marks
            if ($data[0] == $id) {
                $marks = (int)$data[1];
                $grade = self::Result($marks);
                fclose($file);
                return "Marks: $marks, Grade: $grade";
            }
        }

        fclose($file);
        return "No result found for ID: $id";
    }
}

// ---------------- Student Class ----------------
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

    // Print student result
    public function result() {
        $res = LogicalTest::student_result($this->id);
        echo "Student: {$this->name} (ID: {$this->id}, Batch: {$this->batch}) → $res<br>";
    }
}
?>
