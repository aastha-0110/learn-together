<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Complete Your Profile</title>
    <script>
        function toggleFields() {
            const role = document.querySelector('input[name="role"]:checked').value;
            const teacherFields = document.getElementById('teacherFields');
            const learnerFields = document.getElementById('learnerFields');

            if (role === 'teacher') {
                teacherFields.style.display = 'block';
                learnerFields.style.display = 'none';

                document.getElementById('teaching_subject').required = true;
                document.getElementById('experience').required = true;
                document.getElementById('interests').required = false;
            } else {
                teacherFields.style.display = 'none';
                learnerFields.style.display = 'block';

                document.getElementById('interests').required = true;
                document.getElementById('teaching_subject').required = false;
                document.getElementById('experience').required = false;
            }
        }

        window.onload = function() {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            for (let i = 0; i < roleInputs.length; i++) {
                roleInputs[i].addEventListener('change', toggleFields);
            }
        };
    </script>
</head>
<body>
    <header>
        <h1>Complete Your Profile</h1>
    </header>
    <form action="save_user_details.php" method="POST" enctype="multipart/form-data">
        <label for="role">I am a:</label><br>
        <input type="radio" name="role" value="teacher" onclick="toggleFields()" required> Teacher<br>
        <input type="radio" name="role" value="learner" onclick="toggleFields()" required> Learner<br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture" id="profile_picture"><br>

        <div id="teacherFields" style="display: none;">
            <label for="teaching_subject">Teaching Subject:</label>
            <input type="text" name="teaching_subject" id="teaching_subject"><br>

            <label for="experience">Experience:</label>
            <textarea name="experience" id="experience" rows="4"></textarea><br>

            <label for="location">Location:</label>
            <input type="text" name="location" id="location"><br>
        </div>

        <div id="learnerFields" style="display: none;">
            <label for="interests">Interests:</label>
            <input type="text" name="interests" id="interests"><br>

            <label for="location">Location:</label>
            <input type="text" name="location" id="location"><br>
        </div>

        <button type="submit">Save Details</button>
    </form>
</body>
</html>
