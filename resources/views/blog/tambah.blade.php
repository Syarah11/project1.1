@extends('layouts.app')

@section('title', 'Tambah Blog - Portal Blog')

@section('content')
<div class="tambah-blog-container" style="padding: 30px; font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto;">
    
    <h1 style="font-size: 28px; margin-bottom: 25px; color: #333; font-weight: 600;">Tambah Blog</h1>
    
    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
            
            <div>
                <input type="text" 
                       name="judul" 
                       placeholder="Tulis judul blog di sini"
                       required
                       style="width: 100%; 
                              padding: 14px 18px; 
                              border: 1px solid #ddd; 
                              border-radius: 8px; 
                              font-size: 15px;
                              background-color: #e8e8e8;
                              color: #333;
                              text-align: center;
                              transition: all 0.3s;">
            </div>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                
                <div>
                    <div id="toolbar" style="background-color: #f5f5f5; 
                                             border: 1px solid #ddd; 
                                             border-bottom: none;
                                             border-radius: 8px 8px 0 0; 
                                             padding: 10px 15px;
                                             display: flex;
                                             gap: 5px;
                                             flex-wrap: wrap;
                                             align-items: center;">
                        
                        <select onchange="formatDoc('formatBlock', this.value); this.selectedIndex=0;" 
                                style="padding: 5px 10px; 
                                       border: 1px solid #ccc; 
                                       border-radius: 4px; 
                                       background-color: white;
                                       cursor: pointer;
                                       font-size: 13px;">
                            <option selected>Normal</option>
                            <option value="h1">Heading 1</option>
                            <option value="h2">Heading 2</option>
                            <option value="h3">Heading 3</option>
                            <option value="p">Paragraph</option>
                        </select>
                        
                        <div style="width: 1px; height: 24px; background-color: #ddd; margin: 0 5px;"></div>
                        
                        <button type="button" onclick="formatDoc('bold')" title="Bold" 
                                style="width: 32px; height: 32px; border: 1px solid #ccc; border-radius: 4px; background-color: white; cursor: pointer; font-weight: bold; font-size: 14px;">
                            B
                        </button>
                        
                        <button type="button" onclick="formatDoc('italic')" title="Italic" 
                                style="width: 32px; height: 32px; border: 1px solid #ccc; border-radius: 4px; background-color: white; cursor: pointer; font-style: italic; font-size: 14px;">
                            I
                        </button>
                        
                        <button type="button" onclick="formatDoc('underline')" title="Underline" 
                                style="width: 32px; height: 32px; border: 1px solid #ccc; border-radius: 4px; background-color: white; cursor: pointer; text-decoration: underline; font-size: 14px;">
                            U
                        </button>
                        
                        <div style="width: 1px; height: 24px; background-color: #ddd; margin: 0 5px;"></div>
                        
                        <button type="button" onclick="addLink()" title="Insert Link" 
                                style="width: 32px; height: 32px; border: 1px solid #ccc; border-radius: 4px; background-color: white; cursor: pointer; font-size: 14px;">
                            🔗
                        </button>
                        
                        <div style="width: 1px; height: 24px; background-color: #ddd; margin: 0 5px;"></div>
                        
                        <button type="button" onclick="formatDoc('insertOrderedList')" title="Numbered List" 
                                style="width: 32px; height: 32px; border: 1px solid #ccc; border-radius: 4px; background-color: white; cursor: pointer; font-size: 14px;">
                            ≡
                        </button>
                        
                        <button type="button" onclick="formatDoc('insertUnorderedList')" title="Bullet List" 
                                style="width: 32px; height: 32px; border: 1px solid #ccc; border-radius: 4px; background-color: white; cursor: pointer; font-size: 14px;">
                            ☰
                        </button>
                        
                        <div style="width: 1px; height: 24px; background-color: #ddd; margin: 0 5px;"></div>
                        
                        <input type="color" onchange="formatDoc('foreColor', this.value)" title="Text Color"
                               style="width: 32px; height: 32px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer;">
                        
                    </div>
                    
                    <div id="editor" 
                         contenteditable="true"
                         style="width: 100%; 
                                min-height: 300px;
                                padding: 18px; 
                                border: 1px solid #ddd; 
                                border-radius: 0 0 8px 8px; 
                                font-size: 15px;
                                background-color: white;
                                color: #333;
                                font-family: Arial, sans-serif;
                                overflow-y: auto;
                                transition: all 0.3s;"
                         placeholder="Tulis isi blog di sini..."></div>
                    
                    <textarea name="deskripsi" id="deskripsi-hidden" style="display: none;" required></textarea>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    
                    <div>
                        <input type="text" 
                               name="penulis" 
                               placeholder="Penulis"
                               required
                               style="width: 100%; 
                                      padding: 14px 18px; 
                                      border: 1px solid #ddd; 
                                      border-radius: 8px; 
                                      font-size: 15px;
                                      background-color: #e8e8e8;
                                      color: #333;
                                      text-align: center;
                                      transition: all 0.3s;">
                    </div>
                    
                    <div>
                        <select name="kategori" 
                                required
                                style="width: 100%; 
                                       padding: 14px 18px; 
                                       border: 1px solid #ddd; 
                                       border-radius: 8px; 
                                       font-size: 15px;
                                       background-color: #e8e8e8;
                                       color: #333;
                                       text-align: center;
                                       cursor: pointer;
                                       transition: all 0.3s;">
                            <option value="" disabled selected>Kategori</option>
                            <option value="Tutorial">Tutorial</option>
                            <option value="Web Dev">Web Development</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="Backend">Backend</option>
                            <option value="PHP">PHP</option>
                        </select>
                    </div>
                    
                    <div>
                        <input type="text" 
                               name="tag" 
                               placeholder="Tag"
                               style="width: 100%; 
                                      padding: 14px 18px; 
                                      border: 1px solid #ddd; 
                                      border-radius: 8px; 
                                      font-size: 15px;
                                      background-color: #e8e8e8;
                                      color: #333;
                                      text-align: center;
                                      transition: all 0.3s;">
                    </div>
                    
                    <div>
                        <select name="status" 
                                required
                                style="width: 100%; 
                                       padding: 14px 18px; 
                                       border: 1px solid #ddd; 
                                       border-radius: 8px; 
                                       font-size: 15px;
                                       background-color: #e8e8e8;
                                       color: #333;
                                       text-align: center;
                                       cursor: pointer;
                                       transition: all 0.3s;">
                            <option value="" disabled selected>Status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    
                    <div>
                        <div style="width: 100%; 
                                    padding: 40px 18px; 
                                    border: 1px solid #ddd; 
                                    border-radius: 8px; 
                                    background-color: #e8e8e8;
                                    text-align: center;
                                    position: relative;
                                    cursor: pointer;
                                    transition: all 0.3s;"
                             onclick="document.getElementById('gambar-input').click()">
                            <span style="font-size: 15px; color: #333;">Gambar</span>
                            <input type="file" 
                                   id="gambar-input"
                                   name="gambar" 
                                   accept="image/*"
                                   style="display: none;"
                                   onchange="displayFileName(this)">
                        </div>
                        <div id="file-name" style="margin-top: 8px; font-size: 13px; color: #666; text-align: center;"></div>
                    </div>
                    
                    <div style="margin-top: 15px;">
                        <button type="submit" 
                                style="width: 100%; 
                                       padding: 14px 20px; 
                                       background-color: #d0d0d0; 
                                       border: 1px solid #aaa; 
                                       border-radius: 8px; 
                                       font-size: 15px; 
                                       color: #333;
                                       font-weight: 600;
                                       cursor: pointer;
                                       transition: all 0.3s;
                                       box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            Upload
                        </button>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </form>
    
</div>

<style>
    input:focus, textarea:focus, select:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }
    
    input:hover, textarea:hover, select:hover {
        border-color: #bbb;
    }
    
    #editor:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }
    
    #editor:empty:before {
        content: attr(placeholder);
        color: #999;
    }
    
    #toolbar button:hover {
        background-color: #f0f0f0;
    }
    
    #toolbar button:active {
        background-color: #e0e0e0;
    }
    
    button[type="submit"]:hover {
        background-color: #c0c0c0 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
    }
    
    button[type="submit"]:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    div[onclick]:hover {
        border-color: #bbb;
        background-color: #ddd;
    }
</style>

<script>
    function formatDoc(cmd, value = null) {
        document.execCommand(cmd, false, value);
        document.getElementById('editor').focus();
    }
    
    function addLink() {
        const url = prompt('Enter URL:');
        if (url) {
            formatDoc('createLink', url);
        }
    }
    
    function displayFileName(input) {
        const fileName = input.files[0]?.name;
        const fileNameDiv = document.getElementById('file-name');
        if (fileName) {
            fileNameDiv.textContent = '📷 ' + fileName;
            fileNameDiv.style.color = '#4CAF50';
        }
    }
    
    document.querySelector('form').addEventListener('submit', function(e) {
        const editorContent = document.getElementById('editor').innerHTML;
        document.getElementById('deskripsi-hidden').value = editorContent;
        
        if (document.getElementById('editor').textContent.trim() === '') {
            e.preventDefault();
            alert('Deskripsi tidak boleh kosong!');
            return false;
        }
    });
</script>
@endsection