import re
import os

files = [
    'app/views/users/user_list.php',
    'app/views/users/user_form.php'
]

for file_path in files:
    full_path = os.path.join('c:\\xampp\\htdocs\\Gudang_IMS_Logistic', file_path)
    
    if not os.path.exists(full_path):
        print(f'File not found: {full_path}')
        continue
    
    with open(full_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Replace style block with link to main.css
    content = re.sub(
        r'<link href="https://cdn\.jsdelivr\.net/npm/bootstrap@5\.3\.0/dist/css/bootstrap\.min\.css" rel="stylesheet">\s+<style>.*?</style>',
        '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">\n    <link rel="stylesheet" href="assets/css/main.css">',
        content,
        flags=re.DOTALL
    )
    
    with open(full_path, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f'Updated: {file_path}')

print('All files updated successfully!')
