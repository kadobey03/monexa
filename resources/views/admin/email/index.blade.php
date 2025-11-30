@extends('layouts.admin', ['title' => __('admin.emails.title')])

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-admin-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-1">{{ __('admin.emails.title') }}</h1>
                        <p class="text-blue-100 text-lg">{{ __('admin.emails.description') }}</p>
                    </div>
                </div>
                <div>
                    <a href='https://t.me/+VRumJJSKKGdjM2I0'
                       class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl text-white font-semibold transition-all duration-200 backdrop-blur-sm transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        {{ __('common.get_help') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Email Form -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-admin-200 dark:border-admin-700 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    <h2 class="text-xl font-bold text-white">{{ __('admin.emails.compose_form') }}</h2>
                </div>
            </div>
            
            <div class="p-8">
                <form method="post" action="{{ route('sendmailtoall') }}" class="space-y-8" id="emailForm">
                    @csrf

                    <!-- Category Selection -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-6 rounded-xl border border-blue-200 dark:border-blue-700 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">{{ __('admin.emails.recipient_category') }}</h3>
                                <p class="text-blue-700 dark:text-blue-300">{{ __('admin.emails.select_user_group') }}</p>
                            </div>
                        </div>
                        <select class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-admin-900 dark:text-admin-100 transition-all duration-200" id="category" name="category">
                            <option value="All">🌐 {{ __('admin.emails.all_users') }}</option>
                            <option value="No active plans">📊 {{ __('admin.emails.no_active_plans') }}</option>
                            <option value="No deposit">💰 {{ __('admin.emails.no_deposit') }}</option>
                            <option value="Select Users">👤 {{ __('admin.emails.select_users_manual') }}</option>
                        </select>
                    </div>

                    <!-- User Selection (Hidden by default) -->
                    <div class="hidden bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 p-6 rounded-xl border border-amber-200 dark:border-amber-700 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1" id="select-user-view">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-amber-600 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-100">{{ __('admin.emails.user_selection') }}</h3>
                                <p class="text-amber-700 dark:text-amber-300">
                                    {{ __('admin.emails.select_users_to_send') }}
                                    (<span class="text-blue-600 dark:text-blue-400 font-semibold" id="numofusers">0</span> {{ __('admin.emails.people_selected') }})
                                </p>
                            </div>
                        </div>
                        
                        <!-- Custom Multi-Select -->
                        <div class="relative">
                            <div class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl cursor-pointer transition-all duration-200 hover:border-amber-400" id="multiSelectTrigger">
                                <div class="flex items-center justify-between">
                                    <span class="text-admin-900 dark:text-admin-100" id="selectedUsersText">{{ __('admin.emails.select_users_placeholder') }}</span>
                                    <svg class="w-5 h-5 text-admin-500 transition-transform duration-200" id="dropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Dropdown Options -->
                            <div class="absolute z-50 w-full mt-1 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl shadow-lg max-h-60 overflow-y-auto hidden" id="multiSelectDropdown">
                                <div class="p-3 border-b border-admin-200 dark:border-admin-600">
                                    <input type="text" placeholder="{{ __('admin.emails.search_user') }}" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg bg-white dark:bg-admin-800 text-admin-900 dark:text-admin-100 focus:outline-none focus:ring-2 focus:ring-amber-500" id="userSearchInput">
                                </div>
                                <div class="p-2" id="userOptionsList">
                                    <!-- Options will be populated here -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="users[]" id="selectedUsersInput">
                    </div>

                    <!-- Greeting Fields -->
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 p-6 rounded-xl border border-emerald-200 dark:border-emerald-700 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-emerald-600 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-emerald-900 dark:text-emerald-100">{{ __('admin.emails.greeting_and_title') }}</h3>
                                <p class="text-emerald-700 dark:text-emerald-300">{{ __('admin.emails.email_opening_greeting') }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" value="{{ __('admin.emails.default_greeting') }}" name="greet" class="px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-admin-900 dark:text-admin-100 transition-all duration-200" placeholder="{{ __('admin.emails.greeting_placeholder') }}">
                            <input type="text" value="{{ __('admin.emails.default_title') }}" name="title" class="px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-admin-900 dark:text-admin-100 transition-all duration-200" placeholder="{{ __('admin.emails.title_placeholder') }}">
                        </div>
                    </div>

                    <!-- Subject Field -->
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 p-6 rounded-xl border border-cyan-200 dark:border-cyan-700 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-cyan-600 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-cyan-900 dark:text-cyan-100">{{ __('admin.emails.email_subject') }}</h3>
                                <p class="text-cyan-700 dark:text-cyan-300">{{ __('admin.emails.subject_recipients_see') }}</p>
                            </div>
                        </div>
                        <input type="text" name="subject" class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 text-admin-900 dark:text-admin-100 transition-all duration-200" placeholder="{{ __('admin.emails.subject_placeholder') }}" required>
                    </div>

                    <!-- Message Field -->
                    <div class="bg-gradient-to-br from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 p-6 rounded-xl border border-rose-200 dark:border-rose-700 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-rose-600 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-rose-900 dark:text-rose-100">{{ __('admin.emails.email_message') }}</h3>
                                <p class="text-rose-700 dark:text-rose-300">{{ __('admin.emails.email_content_to_send') }}</p>
                            </div>
                        </div>
                        <textarea placeholder="{{ __('admin.emails.message_placeholder') }}" class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 text-admin-900 dark:text-admin-100 transition-all duration-200 ckeditor" name="message" rows="8" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center pt-4">
                        <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" id="submitButton">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            <span id="submitButtonText">{{ __('admin.emails.send_email') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor Latest LTS Version (4.25.1-lts) -->
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard-all/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedUsers = [];
    let allUsers = [];
    let isDropdownOpen = false;

    // Initialize CKEditor with advanced configuration
    let editor = null;
    
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('message', {
            height: 400,
            width: '100%',
            
            // Modern email-focused toolbar
            toolbar: [
                { name: 'document', items: ['Source', '-', 'NewPage', 'Preview', 'Print'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                '/',
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv'] },
                { name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                '/',
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'] },
                '/',
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
            ],

            // Secure file upload configuration with CSRF protection
            filebrowserUploadUrl: "{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}",
            filebrowserImageUploadUrl: "{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}",
            filebrowserUploadMethod: 'form',

            // Enhanced upload settings
            uploadUrl: "{{ route('ckeditor.upload') }}",
            
            // Security and content settings
            allowedContent: true,
            extraAllowedContent: 'img[*]{*};div[*]{*};span[*]{*};p[*]{*};a[*]{*};table[*]{*};tr[*]{*};td[*]{*};th[*]{*};ul[*]{*};ol[*]{*};li[*]{*};h1[*]{*};h2[*]{*};h3[*]{*};h4[*]{*};h5[*]{*};h6[*]{*};strong[*]{*};em[*]{*};u[*]{*}',
            
            // Turkish language support
            language: 'tr',
            defaultLanguage: 'tr',
            
            // Essential plugins for email composition
            extraPlugins: 'uploadimage,image2,colorbutton,colordialog,font,justify,tabletools,tableresize,autogrow,pastetools',
            
            // Remove plugins that interfere with email
            removePlugins: 'elementspath,resize',
            
            // Auto-grow configuration
            autoGrow_onStartup: true,
            autoGrow_minHeight: 250,
            autoGrow_maxHeight: 800,
            autoGrow_bottomSpace: 50,
            
            // Email-friendly format tags
            format_tags: 'p;h1;h2;h3;h4;h5;h6;div',
            
            // Professional font selection for emails
            font_names: 'Arial/Arial, Helvetica, sans-serif;' +
                       'Georgia/Georgia, serif;' +
                       'Times New Roman/Times New Roman, Times, serif;' +
                       'Verdana/Verdana, Geneva, sans-serif;' +
                       'Helvetica/Helvetica, Arial, sans-serif;' +
                       'Tahoma/Tahoma, Geneva, sans-serif;' +
                       'Trebuchet MS/Trebuchet MS, sans-serif;' +
                       'Courier New/Courier New, monospace;',
            
            // Email template styles
            stylesSet: [
                { name: '📧 E-posta Başlığı', element: 'h2', styles: { 'color': '#2563eb', 'font-size': '24px', 'margin': '20px 0 15px 0', 'font-weight': 'bold' } },
                { name: '✨ Vurgu Kutusu', element: 'div', styles: { 'background-color': '#fef3c7', 'padding': '15px', 'border-radius': '8px', 'margin': '15px 0', 'border-left': '4px solid #f59e0b' } },
                { name: '⚠️ Önemli Uyarı', element: 'div', styles: { 'background-color': '#fee2e2', 'border': '1px solid #fca5a5', 'padding': '15px', 'border-radius': '8px', 'margin': '15px 0', 'color': '#dc2626' } },
                { name: '✅ Başarı Mesajı', element: 'div', styles: { 'background-color': '#d1fae5', 'border': '1px solid #6ee7b7', 'padding': '15px', 'border-radius': '8px', 'margin': '15px 0', 'color': '#065f46' } },
                { name: 'ℹ️ Bilgilendirme', element: 'div', styles: { 'background-color': '#dbeafe', 'border': '1px solid #93c5fd', 'padding': '15px', 'border-radius': '8px', 'margin': '15px 0', 'color': '#1e40af' } },
                { name: '🔗 Düğme Stili', element: 'a', styles: { 'background-color': '#3b82f6', 'color': 'white', 'padding': '12px 24px', 'text-decoration': 'none', 'border-radius': '6px', 'display': 'inline-block', 'font-weight': 'bold' } },
                { name: '📝 Alt Yazı', element: 'p', styles: { 'font-size': '14px', 'color': '#6b7280', 'font-style': 'italic', 'margin': '10px 0' } }
            ],

            // Enhanced paste settings for better email content
            pasteFromWordRemoveFontStyles: false,
            pasteFromWordRemoveStyles: false,
            
            // Table settings optimized for emails
            table_defaultWidth: '100%',
            
            // Image settings for email compatibility
            image2_alignClasses: ['image-left', 'image-center', 'image-right'],
            image2_captionedClass: 'image-captioned',
            
            // Email CSS framework
            contentsCss: [
                'body { font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 1.6; color: #333333; background-color: #ffffff; margin: 15px; }',
                'p { margin: 0 0 15px 0; }',
                'h1, h2, h3, h4, h5, h6 { margin: 20px 0 15px 0; line-height: 1.2; }',
                'h1 { font-size: 28px; color: #2563eb; }',
                'h2 { font-size: 24px; color: #2563eb; }',
                'h3 { font-size: 20px; color: #374151; }',
                'img { max-width: 100%; height: auto; border: 0; }',
                'table { border-collapse: collapse; width: 100%; margin: 15px 0; }',
                'table td, table th { border: 1px solid #e5e7eb; padding: 12px; text-align: left; }',
                'table th { background-color: #f9fafb; font-weight: bold; }',
                'a { color: #3b82f6; text-decoration: underline; }',
                'a:hover { color: #1d4ed8; }',
                'blockquote { margin: 15px 0; padding: 15px 20px; background-color: #f8fafc; border-left: 4px solid #3b82f6; font-style: italic; }',
                'ul, ol { margin: 15px 0; padding-left: 30px; }',
                'li { margin: 5px 0; }',
                '.image-left { float: left; margin: 0 15px 15px 0; }',
                '.image-right { float: right; margin: 0 0 15px 15px; }',
                '.image-center { display: block; margin: 15px auto; }'
            ]
        });
        
        // Enhanced editor event handling
        CKEDITOR.on('instanceReady', function(evt) {
            editor = evt.editor;
            
            // Add email-specific CSS
            editor.addContentsCss([
                'body { padding: 20px; max-width: 800px; margin: 0 auto; }',
                '.cke_editable { border: 1px solid #e5e7eb; border-radius: 8px; }'
            ].join(''));
            
            // Set default content if empty
            if (!editor.getData().trim()) {
                editor.setData('<p>{{ __('admin.emails.editor_placeholder') }}</p>');
            }
            
            console.log('✅ CKEditor başarıyla yüklendi ve yapılandırıldı');
            showNotification('{{ __('admin.emails.editor_ready') }}', 'success');
        });
        
        // Enhanced error handling
        CKEDITOR.on('error', function(evt) {
            console.error('❌ CKEditor Hatası:', evt.data);
            showNotification('{{ __('admin.emails.editor_loading_error') }}', 'error');
        });

        // Handle paste events for better email formatting
        CKEDITOR.on('instanceCreated', function(evt) {
            evt.editor.on('paste', function(pasteEvt) {
                // Clean up pasted content for better email compatibility
                const data = pasteEvt.data;
                if (data.dataValue) {
                    // Remove potentially problematic styles for email
                    data.dataValue = data.dataValue
                        .replace(/style="[^"]*"/gi, '') // Remove inline styles that might break in email clients
                        .replace(/<o:p\s*\/?>/gi, '') // Remove Outlook-specific tags
                        .replace(/<\/o:p>/gi, '')
                        .replace(/mso-[^;]+;?/gi, ''); // Remove Microsoft Office styles
                }
            });
        });
        
    } else {
        console.error('❌ CKEditor kütüphanesi yüklenemedi');
        showNotification('{{ __('admin.emails.editor_load_failed') }}', 'error');
    }

    // DOM Elements
    const category = document.querySelector("#category");
    const selectUserView = document.querySelector("#select-user-view");
    const multiSelectTrigger = document.querySelector("#multiSelectTrigger");
    const multiSelectDropdown = document.querySelector("#multiSelectDropdown");
    const dropdownArrow = document.querySelector("#dropdownArrow");
    const selectedUsersText = document.querySelector("#selectedUsersText");
    const selectedUsersInput = document.querySelector("#selectedUsersInput");
    const numOfUsersSpan = document.querySelector("#numofusers");
    const userSearchInput = document.querySelector("#userSearchInput");
    const userOptionsList = document.querySelector("#userOptionsList");
    const submitButton = document.querySelector("#submitButton");
    const submitButtonText = document.querySelector("#submitButtonText");

    // Initial state
    updateCategoryVisibility();

    // Category change handler
    category.addEventListener('change', function() {
        updateCategoryVisibility();
        
        if (this.value === "Select Users" && allUsers.length === 0) {
            loadUsers();
        }
    });

    // Multi-select functionality
    multiSelectTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleDropdown();
    });

    // Search functionality
    userSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterAndRenderUsers(searchTerm);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!multiSelectTrigger.contains(e.target) && !multiSelectDropdown.contains(e.target)) {
            closeDropdown();
        }
    });

    // Form submission handler
    document.querySelector('#emailForm').addEventListener('submit', function(e) {
        if (category.value === "Select Users" && selectedUsers.length === 0) {
            e.preventDefault();
            showNotification('{{ __('admin.emails.select_at_least_one_user') }}', 'error');
            return;
        }

        // Show loading state
        submitButton.disabled = true;
        submitButtonText.innerHTML = '{{ __('admin.emails.sending') }}...';
        submitButton.querySelector('svg').classList.add('animate-spin');

        // Update hidden input with selected users
        updateHiddenInput();
    });

    // Functions
    function updateCategoryVisibility() {
        if (category.value === "Select Users") {
            selectUserView.classList.remove("hidden");
            selectUserView.classList.add("animate-fade-in");
        } else {
            selectUserView.classList.add("hidden");
            selectUserView.classList.remove("animate-fade-in");
            selectedUsers = [];
            updateSelectedUsersDisplay();
        }
    }

    function toggleDropdown() {
        if (isDropdownOpen) {
            closeDropdown();
        } else {
            openDropdown();
        }
    }

    function openDropdown() {
        isDropdownOpen = true;
        multiSelectDropdown.classList.remove('hidden');
        dropdownArrow.style.transform = 'rotate(180deg)';
        userSearchInput.focus();
    }

    function closeDropdown() {
        isDropdownOpen = false;
        multiSelectDropdown.classList.add('hidden');
        dropdownArrow.style.transform = 'rotate(0deg)';
        userSearchInput.value = '';
        filterAndRenderUsers('');
    }

    async function loadUsers() {
        try {
            showLoadingInDropdown();
            
            const response = await fetch("{{ route('fetchusers') }}");
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            allUsers = data.data || [];
            
            if (allUsers.length === 0) {
                showEmptyState();
            } else {
                filterAndRenderUsers('');
            }
            
        } catch (error) {
            console.error('Error fetching users:', error);
            showErrorInDropdown();
        }
    }

    function filterAndRenderUsers(searchTerm = '') {
        const filteredUsers = allUsers.filter(user => 
            user.name.toLowerCase().includes(searchTerm) || 
            user.email.toLowerCase().includes(searchTerm)
        );
        
        renderUsers(filteredUsers);
    }

    function renderUsers(users) {
        if (users.length === 0) {
            userOptionsList.innerHTML = `
                <div class="p-4 text-center text-admin-500 dark:text-admin-400">
                    <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <p>{{ __('admin.emails.no_user_found') }}</p>
                </div>
            `;
            return;
        }

        userOptionsList.innerHTML = users.map(user => `
            <div class="flex items-center p-2 hover:bg-admin-50 dark:hover:bg-admin-600 rounded-lg cursor-pointer transition-colors duration-150 user-option" data-user-id="${user.id}" data-user-name="${user.name}">
                <input type="checkbox" class="w-4 h-4 text-amber-600 bg-admin-100 border-admin-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-admin-800 focus:ring-2 dark:bg-admin-700 dark:border-admin-600 mr-3 user-checkbox" ${selectedUsers.includes(user.id) ? 'checked' : ''}>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-admin-900 dark:text-admin-100 truncate">${user.name}</p>
                    <p class="text-xs text-admin-500 dark:text-admin-400 truncate">${user.email}</p>
                </div>
            </div>
        `).join('');

        // Add click handlers
        document.querySelectorAll('.user-option').forEach(option => {
            option.addEventListener('click', function(e) {
                if (e.target.type !== 'checkbox') {
                    const checkbox = this.querySelector('.user-checkbox');
                    checkbox.checked = !checkbox.checked;
                }
                
                const userId = parseInt(this.dataset.userId);
                const userName = this.dataset.userName;
                const checkbox = this.querySelector('.user-checkbox');
                
                if (checkbox.checked && !selectedUsers.includes(userId)) {
                    selectedUsers.push(userId);
                } else if (!checkbox.checked && selectedUsers.includes(userId)) {
                    selectedUsers = selectedUsers.filter(id => id !== userId);
                }
                
                updateSelectedUsersDisplay();
            });
        });
    }

    function updateSelectedUsersDisplay() {
        const count = selectedUsers.length;
        numOfUsersSpan.textContent = count;
        
        if (count === 0) {
            selectedUsersText.textContent = '{{ __('admin.emails.select_users_placeholder') }}';
            selectedUsersText.className = 'text-admin-500 dark:text-admin-400';
        } else if (count === 1) {
            const selectedUser = allUsers.find(user => user.id === selectedUsers[0]);
            selectedUsersText.textContent = selectedUser ? selectedUser.name : '{{ __('admin.emails.one_user_selected') }}';
            selectedUsersText.className = 'text-admin-900 dark:text-admin-100 font-medium';
        } else {
            selectedUsersText.textContent = `${count} {{ __('admin.emails.users_selected') }}`;
            selectedUsersText.className = 'text-admin-900 dark:text-admin-100 font-medium';
        }
        
        updateHiddenInput();
    }

    function updateHiddenInput() {
        // Create multiple hidden inputs for array submission
        const existingInputs = document.querySelectorAll('input[name="users[]"]');
        existingInputs.forEach(input => input.remove());
        
        selectedUsers.forEach(userId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'users[]';
            input.value = userId;
            document.querySelector('#emailForm').appendChild(input);
        });
    }

    function showLoadingInDropdown() {
        userOptionsList.innerHTML = `
            <div class="p-4 text-center">
                <div class="inline-flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-admin-600 dark:text-admin-300">{{ __('admin.emails.loading_users') }}</span>
                </div>
            </div>
        `;
    }

    function showEmptyState() {
        userOptionsList.innerHTML = `
            <div class="p-4 text-center text-admin-500 dark:text-admin-400">
                <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <p>{{ __('admin.emails.no_users_found') }}</p>
            </div>
        `;
    }

    function showErrorInDropdown() {
        userOptionsList.innerHTML = `
            <div class="p-4 text-center text-red-500 dark:text-red-400">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p>{{ __('admin.emails.users_loading_error') }}</p>
                <button type="button" class="mt-2 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" onclick="loadUsers()">
                    {{ __('common.try_again') }}
                </button>
            </div>
        `;
    }

    function showNotification(message, type = 'info') {
        // Simple notification system - could be expanded
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full ${
            type === 'error' ? 'bg-red-500 text-white' : 
            type === 'success' ? 'bg-green-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Style additions for animations
    const style = document.createElement('style');
    style.textContent = `
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush