<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ask Codellama</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="QuantumByteStudios">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">
    <!-- GoogleFonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Prism CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">
    <!-- Inline CSS -->
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }

        input {
            box-shadow: none !important;
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center">
        <!-- Content -->
        <div class="card mt-5 p-5 animate__animated animate__fadeIn w-50">
            <!-- Input -->
            <div class="alert m-3">
                <h2>Ask Codellama</h2>
                <form action="" method="POST">
                    <div class="btn-group w-100">
                        <input class="form-control rounded-0 rounded-start" type="text" name="prompt"
                            autocomplete="off">
                        <button class="btn btn-danger rounded-end" type="submit">Submit</button>
                    </div>
                </form>
            </div>
            <!-- Output -->
            <div class="alert m-3">
                <h2>Output</h2>
                <p>
                    <?php

                    function printFormattedText($text)
                    {
                        preg_match('/```(.*?)```/s', $text, $matches);
                        $code = isset($matches[1]) ? $matches[1] : '';
                        $text = preg_replace('/```(.*?)```/s', '<div id="code"><pre><code class="language-javascript">' . $code . '</code></pre></div>', $text);
                        return $text;
                    }

                    function askCodeLlama($prompt)
                    {
                        if (empty($prompt)) {
                            echo 'No prompt provided';
                            exit;
                        } else {
                            // GET THE OUTPUT FROM THE SHELL COMMAND
                            $command = 'ollama run codellama "' . $prompt . '"';
                            $output = shell_exec($command);

                            // STAGE ONE FORMATTING - Replace new lines with <br> tags and remove backslashes
                            $new = nl2br($output);
                            $stage_one_formatting = str_replace('\n', '<br>', $new);
                            // echo $stage_one_formatting;
                    
                            // STAGE TWO FORMATTING - Highlight the code block
                            $stage_two_formatting = $stage_one_formatting;
                            echo printFormattedText($stage_two_formatting);
                        }
                    }

                    if (isset($_POST['prompt'])) {
                        $prompt = $_POST['prompt'];
                        askCodeLlama($prompt);
                    } else {
                        echo "No prompt provided";
                    }
                    ?>
                </p>
            </div>
        </div>
        <!-- Content -->
    </div>

</body>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
<!-- Prism Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Prism.highlightAll();
    });
</script>

</html>