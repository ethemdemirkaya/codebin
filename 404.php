<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Code Not Found | CodeBin</title>
    <meta name="description" content="The code snippet you're looking for was not found">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style_new.css">
</head>

<body class="error-page">
    <div class="header">
        <div class="logo">
            <a href="/" style="text-decoration: none; color: inherit;">CodeBin</a>
        </div>
        <div class="controls">
            <button id="newBtn" class="btn" onclick="window.location.href='/'">New</button>
        </div>
    </div>
    
    <div class="error-container">
        <div class="error-content">
            <div class="error-code">404</div>
            <div class="error-title">Code Not Found</div>
            <div class="error-message">
                <p>The code snippet you're looking for doesn't exist or may have been removed.</p>
                <p>Please check the URL and try again.</p>
            </div>
            
            <div class="error-actions">
                <button class="btn btn-primary" onclick="window.location.href='/'">
                    <span>📝</span> Create New Code
                </button>
                <button class="btn btn-secondary" onclick="window.history.back()">
                    <span>←</span> Go Back
                </button>
            </div>
            
            <div class="error-tips">
                <h3>Tips:</h3>
                <ul>
                    <li>Make sure the URL is correct</li>
                    <li>The code might have expired</li>
                    <li>Try creating a new code snippet</li>
                </ul>
            </div>
        </div>
        
        <div class="ascii-art">
            <pre>
    ┌─┐┌─┐┌┬┐┌─┐  ┌┐┌┌─┐┌┬┐  ┌─┐┌─┐┬ ┬┌┐┌┌┬┐
    │  │ │ ││├┤   ││││ │ │   ├┤ │ ││ ││││ ││
    └─┘└─┘─┴┘└─┘  ┘└┘└─┘ ┴   └  └─┘└─┘┘└┘─┴┘
            </pre>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorCode = document.querySelector('.error-code');
            const errorTitle = document.querySelector('.error-title');
            
            setTimeout(() => {
                errorCode.style.transform = 'translateY(0)';
                errorCode.style.opacity = '1';
            }, 100);
            
            setTimeout(() => {
                errorTitle.style.transform = 'translateY(0)';
                errorTitle.style.opacity = '1';
            }, 300);
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'n' && !e.ctrlKey && !e.metaKey) {
                    window.location.href = '/';
                }
                if (e.key === 'Escape') {
                    window.history.back();
                }
            });
        });
    </script>
</body>

</html>