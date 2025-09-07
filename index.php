<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeBin</title>
    <meta name="description" content="Share code snippets quickly and easily">
    
    <!-- Modern IDE Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style_new.css">
</head>

<body>
    <div class="header">
        <div class="logo">CodeBin</div>
        <div class="controls">
            <button id="saveBtn" class="btn" disabled>Save</button>
            <button id="newBtn" class="btn">New</button>
        </div>
    </div>
    
    <div class="main-container">
        <div class="line-numbers" id="lineNumbers">1</div>
        <textarea 
            name="code" 
            id="code"
            placeholder="Paste your code here..."
            spellcheck="false"
            autocomplete="off"
            autocorrect="off"
            autocapitalize="off"
        ></textarea>
    </div>
    
    <script>
        const textarea = document.getElementById('code');
        const lineNumbers = document.getElementById('lineNumbers');
        const saveBtn = document.getElementById('saveBtn');
        const newBtn = document.getElementById('newBtn');
        
        // Update line numbers
        function updateLineNumbers() {
            const lines = textarea.value.split('\n').length;
            let lineNumbersText = '';
            for (let i = 1; i <= lines; i++) {
                lineNumbersText += i + '\n';
            }
            lineNumbers.textContent = lineNumbersText;
        }
        
        function updateSaveButton() {
            saveBtn.disabled = textarea.value.trim() === '';
        }
        
        textarea.addEventListener('input', function() {
            updateLineNumbers();
            updateSaveButton();
        });
        
        textarea.addEventListener('scroll', function() {
            lineNumbers.scrollTop = textarea.scrollTop;
        });
        
        saveBtn.addEventListener('click', function() {
            if (textarea.value.trim() === '') return;
            
            saveBtn.textContent = 'Saving...';
            saveBtn.disabled = true;
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'save.php';
            
            const codeInput = document.createElement('input');
            codeInput.type = 'hidden';
            codeInput.name = 'code';
            codeInput.value = textarea.value;
            
            form.appendChild(codeInput);
            document.body.appendChild(form);
            form.submit();
        });
        
        newBtn.addEventListener('click', function() {
            if (textarea.value.trim() !== '') {
                if (confirm('Are you sure you want to create a new document? Unsaved changes will be lost.')) {
                    textarea.value = '';
                    updateLineNumbers();
                    updateSaveButton();
                    textarea.focus();
                }
            } else {
                textarea.focus();
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                if (!saveBtn.disabled) {
                    saveBtn.click();
                }
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                newBtn.click();
            }
        });
        updateLineNumbers();
        updateSaveButton();
        textarea.focus();
    </script>
</body>

</html>