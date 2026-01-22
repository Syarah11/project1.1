@extends('layouts.app')

@section('title', 'Tambah Blog - Portal Blog')

@section('content')
<div class="tambah-blog-container" style="padding: 30px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 1200px; margin: 0 auto; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; border-radius: 16px;">
    
    <h1 style="font-size: 32px; margin-bottom: 30px; color: #2d3748; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; display: flex; align-items: center; gap: 12px;">
        <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">✍️ Tambah Blog Baru</span>
    </h1>
    
    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr; gap: 25px;">
            
            <!-- Judul Input -->
            <div style="position: relative;">
                <input type="text" 
                       name="judul" 
                       placeholder="📝 Tulis judul blog di sini..."
                       required
                       style="width: 100%; 
                              padding: 18px 24px; 
                              border: 2px solid transparent;
                              border-radius: 12px; 
                              font-size: 16px;
                              background: white;
                              color: #2d3748;
                              text-align: center;
                              font-weight: 500;
                              transition: all 0.3s;
                              box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            </div>
            
            <!-- Main Grid: Editor + Sidebar -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px;">
                
                <!-- Editor Section -->
                <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); position: relative;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);"></div>
                    
                    <!-- Toolbar -->
                    <div id="toolbar" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                                             border-bottom: 2px solid #e0e0e0;
                                             padding: 12px 18px;
                                             display: flex;
                                             gap: 8px;
                                             flex-wrap: wrap;
                                             align-items: center;">
                        
                        <select onchange="formatDoc('formatBlock', this.value); this.selectedIndex=0;" 
                                style="padding: 8px 14px; 
                                       border: 2px solid #e0e0e0; 
                                       border-radius: 8px; 
                                       background: white;
                                       cursor: pointer;
                                       font-size: 13px;
                                       font-weight: 500;
                                       color: #2d3748;
                                       transition: all 0.2s;">
                            <option selected>Normal</option>
                            <option value="h1">Heading 1</option>
                            <option value="h2">Heading 2</option>
                            <option value="h3">Heading 3</option>
                            <option value="p">Paragraph</option>
                        </select>
                        
                        <div style="width: 2px; height: 28px; background: linear-gradient(180deg, #667eea 0%, #764ba2 100%); margin: 0 6px; border-radius: 2px;"></div>
                        
                        <button type="button" onclick="formatDoc('bold')" title="Bold" 
                                style="width: 38px; height: 38px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; font-weight: bold; font-size: 15px; color: #2d3748; transition: all 0.2s;">
                            B
                        </button>
                        
                        <button type="button" onclick="formatDoc('italic')" title="Italic" 
                                style="width: 38px; height: 38px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; font-style: italic; font-size: 15px; color: #2d3748; transition: all 0.2s;">
                            I
                        </button>
                        
                        <button type="button" onclick="formatDoc('underline')" title="Underline" 
                                style="width: 38px; height: 38px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; text-decoration: underline; font-size: 15px; color: #2d3748; transition: all 0.2s;">
                            U
                        </button>
                        
                        <div style="width: 2px; height: 28px; background: linear-gradient(180deg, #f093fb 0%, #f5576c 100%); margin: 0 6px; border-radius: 2px;"></div>
                        
                        <button type="button" onclick="addLink()" title="Insert Link" 
                                style="width: 38px; height: 38px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; font-size: 16px; transition: all 0.2s;">
                            🔗
                        </button>
                        
                        <div style="width: 2px; height: 28px; background: linear-gradient(180deg, #4facfe 0%, #00f2fe 100%); margin: 0 6px; border-radius: 2px;"></div>
                        
                        <button type="button" onclick="formatDoc('insertOrderedList')" title="Numbered List" 
                                style="width: 38px; height: 38px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; font-size: 16px; color: #2d3748; transition: all 0.2s;">
                            ≡
                        </button>
                        
                        <button type="button" onclick="formatDoc('insertUnorderedList')" title="Bullet List" 
                                style="width: 38px; height: 38px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; font-size: 16px; color: #2d3748; transition: all 0.2s;">
                            ☰
                        </button>
                        
                        <div style="width: 2px; height: 28px; background: linear-gradient(180deg, #667eea 0%, #764ba2 100%); margin: 0 6px; border-radius: 2px;"></div>
                        
                        <input type="color" onchange="formatDoc('foreColor', this.value)" title="Text Color"
                               style="width: 38px; height: 38px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer;">
                        
                    </div>
                    
                    <!-- Editor Area -->
                    <div id="editor" 
                         contenteditable="true"
                         style="width: 100%; 
                                min-height: 400px;
                                padding: 24px; 
                                font-size: 15px;
                                background: white;
                                color: #2d3748;
                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                overflow-y: auto;
                                line-height: 1.8;
                                transition: all 0.3s;"
                         placeholder="✨ Tulis isi blog di sini..."></div>
                    
                    <textarea name="deskripsi" id="deskripsi-hidden" style="display: none;" required></textarea>
                </div>
                
                <!-- Sidebar Form -->
                <div style="display: flex; flex-direction: column; gap: 18px;">
                    
                    <!-- Penulis -->
                    <div style="position: relative;">
                        <span style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-size: 18px;">👤</span>
                        <input type="text" 
                               name="penulis" 
                               placeholder="Penulis"
                               required
                               style="width: 100%; 
                                      padding: 16px 20px 16px 50px; 
                                      border: 2px solid transparent;
                                      border-radius: 12px; 
                                      font-size: 15px;
                                      background: white;
                                      color: #2d3748;
                                      font-weight: 500;
                                      transition: all 0.3s;
                                      box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    </div>
                    
                    <!-- Kategori -->
                    <div style="position: relative;">
                        <span style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-size: 18px; z-index: 1;">📁</span>
                        <select name="kategori" 
                                required
                                style="width: 100%; 
                                       padding: 16px 20px 16px 50px; 
                                       border: 2px solid transparent;
                                       border-radius: 12px; 
                                       font-size: 15px;
                                       background: white;
                                       color: #2d3748;
                                       font-weight: 500;
                                       cursor: pointer;
                                       transition: all 0.3s;
                                       box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                                       appearance: none;">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Tutorial">Tutorial</option>
                            <option value="Web Dev">Web Development</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="Backend">Backend</option>
                            <option value="PHP">PHP</option>
                        </select>
                    </div>
                    
                    <!-- Tag -->
                    <div style="position: relative;">
                        <span style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-size: 18px;">🏷️</span>
                        <input type="text" 
                               name="tag" 
                               placeholder="Tag (pisahkan dengan koma)"
                               style="width: 100%; 
                                      padding: 16px 20px 16px 50px; 
                                      border: 2px solid transparent;
                                      border-radius: 12px; 
                                      font-size: 15px;
                                      background: white;
                                      color: #2d3748;
                                      font-weight: 500;
                                      transition: all 0.3s;
                                      box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    </div>
                    
                    <!-- Status -->
                    <div style="position: relative;">
                        <span style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-size: 18px; z-index: 1;">📊</span>
                        <select name="status" 
                                required
                                style="width: 100%; 
                                       padding: 16px 20px 16px 50px; 
                                       border: 2px solid transparent;
                                       border-radius: 12px; 
                                       font-size: 15px;
                                       background: white;
                                       color: #2d3748;
                                       font-weight: 500;
                                       cursor: pointer;
                                       transition: all 0.3s;
                                       box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                                       appearance: none;">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="draft">📝 Draft</option>
                            <option value="published">✅ Published</option>
                        </select>
                    </div>
                    
                    <!-- Upload Gambar -->
                    <div>
                        <div style="width: 100%; 
                                    padding: 50px 20px; 
                                    border: 3px dashed #cbd5e0;
                                    border-radius: 12px; 
                                    background: white;
                                    text-align: center;
                                    position: relative;
                                    cursor: pointer;
                                    transition: all 0.3s;
                                    box-shadow: 0 4px 12px rgba(0,0,0,0.08);"
                             onclick="document.getElementById('gambar-input').click()">
                            <div style="font-size: 48px; margin-bottom: 12px;">📷</div>
                            <span style="font-size: 15px; color: #4a5568; font-weight: 500;">Klik untuk upload gambar</span>
                            <div style="font-size: 12px; color: #718096; margin-top: 6px;">PNG, JPG, JPEG (Max 5MB)</div>
                            <input type="file" 
                                   id="gambar-input"
                                   name="gambar" 
                                   accept="image/*"
                                   style="display: none;"
                                   onchange="displayFileName(this)">
                        </div>
                        <div id="file-name" style="margin-top: 10px; font-size: 13px; color: #4a5568; text-align: center; font-weight: 500;"></div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div style="margin-top: 10px;">
                        <button type="submit" 
                                style="width: 100%; 
                                       padding: 18px 24px; 
                                       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                       border: none;
                                       border-radius: 12px; 
                                       font-size: 16px; 
                                       color: white;
                                       font-weight: 700;
                                       cursor: pointer;
                                       transition: all 0.3s;
                                       box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
                                       letter-spacing: 0.5px;">
                            🚀 Upload Blog
                        </button>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </form>
    
</div>

<style>
    /* Input Focus States */
    input:focus, textarea:focus, select:focus {
        outline: none;
        border-color: #667eea !important;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15) !important;
        transform: translateY(-2px);
    }
    
    input:hover, textarea:hover, select:hover {
        border-color: #a0aec0;
        transform: translateY(-1px);
    }
    
    /* Editor Focus */
    #editor:focus {
        outline: none;
    }
    
    #editor:empty:before {
        content: attr(placeholder);
        color: #a0aec0;
    }
    
    /* Toolbar Button Hover */
    #toolbar button:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        border-color: #667eea !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    #toolbar button:active {
        transform: translateY(0);
    }
    
    #toolbar select:hover {
        border-color: #667eea;
        transform: translateY(-1px);
    }
    
    /* Submit Button Hover */
    button[type="submit"]:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5) !important;
    }
    
    button[type="submit"]:active {
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
    }
    
    /* File Upload Hover */
    div[onclick]:hover {
        border-color: #667eea !important;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12) !important;
    }
    
    /* Smooth Animations */
    * {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<script>
    function formatDoc(cmd, value = null) {
        document.execCommand(cmd, false, value);
        document.getElementById('editor').focus();
    }
    
    function addLink() {
        const url = prompt('Masukkan URL:');
        if (url) {
            formatDoc('createLink', url);
        }
    }
    
    function displayFileName(input) {
        const fileName = input.files[0]?.name;
        const fileNameDiv = document.getElementById('file-name');
        if (fileName) {
            fileNameDiv.innerHTML = '✅ <strong style="color: #48bb78;">' + fileName + '</strong>';
        }
    }
    
    document.querySelector('form').addEventListener('submit', function(e) {
        const editorContent = document.getElementById('editor').innerHTML;
        document.getElementById('deskripsi-hidden').value = editorContent;
        
        if (document.getElementById('editor').textContent.trim() === '') {
            e.preventDefault();
            alert('⚠️ Deskripsi tidak boleh kosong!');
            return false;
        }
    });
</script>
@endsection