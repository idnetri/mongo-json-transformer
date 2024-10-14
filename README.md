# Mongo JSON Transformer

Try the live app here: [Mongo JSON Transformer App](https://tripurnomo.com/apps/json-to-mongo.php)

A powerful tool that transforms MongoDB-specific JSON formats into shell-friendly formats for direct execution in the MongoDB shell.

## Features:
- Converts MongoDB `$date` fields to `new Date()` for direct use in queries.
- Converts `$oid` fields to `ObjectId()` to match MongoDB shell format.
- Easy copy-paste functionality for quick integration.
- Reset button to clear form and start over.

## Usage:
1. Paste your JSON data (containing `$date` or `$oid`) into the textarea.
2. Click "Convert" to transform the fields into `new Date()` and `ObjectId()` formats.
3. Copy the result and use it directly in the MongoDB shell or queries.
4. Use the reset button if you need to convert new data.

## Ideal For:
- Developers working with MongoDB data exports or backups.
- Data migration and transformation tasks.
- Quickly converting JSON for testing and execution in the MongoDB shell.
