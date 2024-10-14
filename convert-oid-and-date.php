<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convert JSON Date and ObjectId Format</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            margin-top: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        .button-container {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        .button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .convert-btn {
            background-color: #4CAF50;
            color: white;
        }
        .reset-btn {
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            font-size: 12px;
        }
        .copy-btn {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>Convert JSON Date and ObjectId Format</h2>

<form method="post" id="jsonForm">
    <label for="jsonInput">Enter JSON:</label><br>
    <textarea id="jsonInput" name="jsonInput"><?php echo isset($_POST['jsonInput']) ? htmlentities($_POST['jsonInput']) : ''; ?></textarea><br>
    <div class="button-container">
        <input type="submit" name="convert" value="Convert" class="button convert-btn">
        <button type="button" class="reset-btn button" onclick="resetForm()">Reset</button>
    </div>
</form>

<?php
if (isset($_POST['convert'])) {
    $inputText = $_POST['jsonInput'];

    // Function to replate $date -> $numberLong, and $oid
    function replace_date_oid($text) {
        // "Regex pattern to capture the structure `"$date": {"$numberLong": "timestamp"}`, including negative timestamps."
        $patternDate = '/"\$date"\s*:\s*\{\s*"\$numberLong"\s*:\s*"(-?\d+)"\s*\}/';
        // "Regex pattern to capture the structure `"$oid": "objectId"`."
        $patternOid = '/"\$oid"\s*:\s*"([a-fA-F0-9]{24})"/';

        // Function to replace $date -> new Date(timestamp)
        $replacementDate = function ($matches) {
            $timestamp = $matches[1];
            return "new Date($timestamp)";
        };

        // Function to change $oid -> ObjectId("objectId")
        $replacementOid = function ($matches) {
            $oid = $matches[1];
            return "ObjectId(\"$oid\")";
        };

        // "Perform replacement for `$date` and `$oid`."
        $replacedText = preg_replace_callback($patternDate, $replacementDate, $text);
        $replacedText = preg_replace_callback($patternOid, $replacementOid, $replacedText);

        // "Remove the extra curly braces around `new Date` and `ObjectId` if present."
        $replacedText = preg_replace('/\{\s*new Date\((\-?\d+)\)\s*\}/', 'new Date($1)', $replacedText);
        $replacedText = preg_replace('/\{\s*ObjectId\("([a-fA-F0-9]{24})"\)\s*\}/', 'ObjectId("$1")', $replacedText);

        return $replacedText;
    }

    $convertedText = replace_date_oid($inputText);

    echo '<h3>Converted Result:</h3>';
    echo '<textarea id="convertedResult">' . htmlentities($convertedText) . '</textarea><br>';
    echo '<button class="copy-btn" onclick="copyToClipboard()">Copy</button>';
}
?>

<script>
function copyToClipboard() {
    var copyText = document.getElementById("convertedResult").value; // Get All Text from textarea

    navigator.clipboard.writeText(copyText).then(function() {
        alert("Copied to clipboard!");
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
    });
}

// Function to reset form
function resetForm() {
    if (confirm("Are you sure you want to reset the form?")) {
        document.getElementById("jsonForm").reset(); // Reset form
        document.getElementById("jsonInput").value = ""; // Reset textarea
    }
}
</script>

</body>
</html>
