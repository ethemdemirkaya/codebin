<?php
$id = $_GET['id'] ?? '';
if (!preg_match('/^[a-zA-Z0-9]+$/', $id)) {
    http_response_code(400);
    die("Invalid ID format.");
}

$filename = $id;
$filepath = 'pastes/' . $filename;

if (!file_exists($filepath)) {
    http_response_code(404);
    echo "<!DOCTYPE html><html lang='en'><head><title>404 Not Found</title><link rel='stylesheet' href='/style.css'></head><body><div class='container message'><h1>404 - Not Found</h1><p>The code snippet you're looking for was not found.</p><a href='/' class='btn'>Go Home</a></div></body></html>";
    exit();
}

$code_content = file_get_contents($filepath);

// Handle raw view
if (isset($_GET['raw'])) {
    header('Content-Type: text/plain; charset=utf-8');
    echo $code_content;
    exit();
}

$safe_code = htmlspecialchars($code_content, ENT_QUOTES, 'UTF-8');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeBin - <?php echo htmlspecialchars($filename); ?></title>

    <!-- Modern IDE Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="style_new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
</head>

<body class="code-view">
    <div class="header">
        <div class="logo">CodeBin</div>
        <div class="controls">
            <button id="copyBtn" class="btn">Copy</button>
            <button id="rawBtn" class="btn">Raw</button>
            <button id="newBtn" class="btn">New</button>
        </div>
    </div>
    
    <div class="view-container">
        <div class="line-numbers" id="lineNumbers"></div>
        <pre class="code-content"><code id="codeBlock"><?php echo $safe_code; ?></code></pre>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeBlock = document.getElementById('codeBlock');
            const lineNumbers = document.getElementById('lineNumbers');
            const copyBtn = document.getElementById('copyBtn');
            const rawBtn = document.getElementById('rawBtn');
            const newBtn = document.getElementById('newBtn');
            
            // Apply syntax highlighting
            hljs.highlightElement(codeBlock);
            
            // Generate line numbers
            const lines = codeBlock.textContent.split('\n');
            let lineNumbersText = '';
            for (let i = 1; i <= lines.length; i++) {
                lineNumbersText += i + '\n';
            }
            lineNumbers.textContent = lineNumbersText;
            
            // Sync scroll
            const codeContainer = document.querySelector('.code-content');
            codeContainer.addEventListener('scroll', function() {
                lineNumbers.scrollTop = codeContainer.scrollTop;
            });
            
            // Copy functionality
            copyBtn.addEventListener('click', function() {
                navigator.clipboard.writeText(codeBlock.textContent).then(function() {
                    copyBtn.textContent = 'Copied!';
                    setTimeout(function() {
                        copyBtn.textContent = 'Copy';
                    }, 2000);
                }).catch(function() {
                    // Fallback for older browsers
                    const textarea = document.createElement('textarea');
                    textarea.value = codeBlock.textContent;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    copyBtn.textContent = 'Copied!';
                    setTimeout(function() {
                        copyBtn.textContent = 'Copy';
                    }, 2000);
                });
            });
            
            // Raw view
            rawBtn.addEventListener('click', function() {
                const currentUrl = window.location.href;
                const separator = currentUrl.includes('?') ? '&' : '?';
                const rawUrl = currentUrl + separator + 'raw=1';
                window.open(rawUrl, '_blank');
            });
            
            // New document
            newBtn.addEventListener('click', function() {
                window.location.href = '/';
            });
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Override Ctrl+A to select only code content
                if ((e.ctrlKey || e.metaKey) && e.key === 'a') {
                    e.preventDefault();
                    const selection = window.getSelection();
                    const range = document.createRange();
                    range.selectNodeContents(codeBlock);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
                
                if (e.key === 'c' && !e.ctrlKey && !e.metaKey) {
                    copyBtn.click();
                }
                if (e.key === 'r' && !e.ctrlKey && !e.metaKey) {
                    rawBtn.click();
                }
                if (e.key === 'n' && !e.ctrlKey && !e.metaKey) {
                    newBtn.click();
                }
            });
        });
    </script>
</body>

</html>