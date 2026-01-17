<!-- resources/views/blog/tambah.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Blog - Portal Blog')

@section('content')
<div class="tambah-blog-container" style="padding: 30px; font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto;">
    
    <!-- Title -->
    <h1 style="font-size: 28px; margin-bottom: 25px; color: #333; font-weight: 600;">Tambah Blog</h1>
    
    <!-- Form -->
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
            
            <!-- Judul -->
            <div>
                <input type="text" 
                       name="judul" 
                       placeholder="Judul"
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
                
                <!-- Deskripsi (Left Column) -->
                <div>
                    <textarea name="deskripsi" 
                              placeholder="Deskripsi"
                              rows="10"
                              required
                              style="width: 100%; 
                                     padding: 18px; 
                                     border: 1px solid #ddd; 
                                     border-radius: 8px; 
                                     font-size: 15px;
                                     background-color: #e8e8e8;
                                     color: #333;
                                     resize: vertical;
                                     font-family: Arial, sans-serif;
                                     display: flex;
                                     align-items: center;
                                     justify-content: center;
                                     text-align: center;
                                     transition: all 0.3s;"></textarea>
                </div>
                
                <!-- Right Column Fields -->
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    
                    <!-- Penulis -->
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
                    
                    <!-- Kategori -->
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
                    
                    <!-- Tag -->
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
                    
                    <!-- Status -->
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
                    
                    <!-- Gambar -->
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
                    
                    <!-- Upload Button -->
                    <div style="margin-top: 10px;">
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
                                       transition: all 0.3s;">
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
    
    button[type="submit"]:hover {
        background-color: #c0c0c0 !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    div[onclick]:hover {
        border-color: #bbb;
        background-color: #ddd;
    }
</style>

<script>
    function displayFileName(input) {
        const fileName = input.files[0]?.name;
        const fileNameDiv = document.getElementById('file-name');
        if (fileName) {
            fileNameDiv.textContent = '📷 ' + fileName;
            fileNameDiv.style.color = '#4CAF50';
        }
    }
</script>
@endsection