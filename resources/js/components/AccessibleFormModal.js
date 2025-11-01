/**
 * AccessibleFormModal Component - Form ve Modal Erişilebilirlik Bileşeni
 * 
 * Form validasyonu, hata mesajları, modal erişilebilirliği
 * ARIA state yönetimi ve real-time form feedback'i sağlar
 */

class AccessibleFormModal {
    constructor() {
        this.forms = new Map();
        this.modals = new Map();
        this.focusHistory = [];
        this.currentForm = null;
        this.currentModal = null;
        this.validationRules = new Map();
        this.announcementDelay = 100;
        
        this.init();
    }

    /**
     * Bileşeni başlat
     */
    init() {
        this.setupFormEnhancements();
        this.setupModalEnhancements();
        this.setupValidation();
        this.bindEvents();
        
        console.log('AccessibleFormModal initialized');
    }

    /**
     * Form iyileştirmelerini kur
     */
    setupFormEnhancements() {
        // Mevcut formları otomatik olarak iyileştir
        document.addEventListener('DOMContentLoaded', () => {
            this.enhanceAllForms();
        });
        
        // Yeni formlar için observer
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        if (node.tagName === 'FORM') {
                            this.enhanceForm(node);
                        } else {
                            // Form içindeki elementleri kontrol et
                            const forms = node.querySelectorAll('form');
                            forms.forEach(form => this.enhanceForm(form));
                        }
                    }
                });
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    /**
     * Tüm formları iyileştir
     */
    enhanceAllForms() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => this.enhanceForm(form));
    }

    /**
     * Tek formu iyileştir
     */
    enhanceForm(form) {
        if (this.forms.has(form)) return; // Zaten iyileştirilmiş
        
        const formId = this.generateFormId(form);
        const formData = {
            id: formId,
            element: form,
            fields: new Map(),
            errors: new Map(),
            validationRules: new Map(),
            submitted: false,
            enhanced: true
        };
        
        // Form özelliklerini ekle
        this.addFormAttributes(form, formId);
        
        // Field'ları iyileştir
        this.enhanceFormFields(form, formData);
        
        // Submit handling
        this.enhanceFormSubmission(form, formData);
        
        // Real-time validation
        this.setupRealTimeValidation(form, formData);
        
        this.forms.set(form, formData);
        
        console.log(`Enhanced form: ${formId}`);
    }

    /**
     * Form attributes ekle
     */
    addFormAttributes(form, formId) {
        form.setAttribute('data-accessibility-enhanced', 'true');
        form.setAttribute('data-form-id', formId);
        form.setAttribute('novalidate', ''); // Disable browser validation
        form.setAttribute('aria-describedby', `form-description-${formId}`);
        
        // Form description oluştur
        let description = form.querySelector(`#form-description-${formId}`);
        if (!description) {
            description = document.createElement('div');
            description.id = `form-description-${formId}`;
            description.className = 'sr-only';
            description.textContent = 'Bu form keyboard ile gezinilebilir. Tab tuşu ile alanlar arasında geçiş yapabilirsiniz. Hata mesajları otomatik olarak duyurulacaktır.';
            form.insertBefore(description, form.firstChild);
        }
        
        // Error container ekle
        let errorContainer = form.querySelector('.form-errors-container');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.id = `form-errors-${formId}`;
            errorContainer.className = 'sr-only';
            errorContainer.setAttribute('aria-live', 'polite');
            errorContainer.setAttribute('aria-label', 'Form hata mesajları');
            form.insertBefore(errorContainer, description.nextSibling);
        }
        
        // Success container ekle
        let successContainer = form.querySelector('.form-success-container');
        if (!successContainer) {
            successContainer = document.createElement('div');
            successContainer.id = `form-success-${formId}`;
            successContainer.className = 'sr-only';
            successContainer.setAttribute('aria-live', 'polite');
            successContainer.setAttribute('aria-label', 'Form başarı mesajları');
            form.insertBefore(successContainer, errorContainer.nextSibling);
        }
    }

    /**
     * Form field'larını iyileştir
     */
    enhanceFormFields(form, formData) {
        const fields = form.querySelectorAll('input, select, textarea');
        
        fields.forEach(field => {
            this.enhanceFormField(field, formData);
        });
    }

    /**
     * Tek field'ı iyileştir
     */
    enhanceFormField(field, formData) {
        const fieldId = this.generateFieldId(field);
        const fieldData = {
            id: fieldId,
            element: field,
            form: formData,
            hasError: false,
            hasSuccess: false,
            rules: [],
            errorElements: new Map(),
            label: null,
            description: null
        };
        
        // Label ve description bul
        this.associateFieldWithLabel(field, fieldData);
        this.associateFieldWithDescription(field, fieldData);
        
        // ARIA attributes ekle
        this.addFieldAttributes(field, fieldData);
        
        // Validation styling ekle
        this.addFieldStyling(field, fieldData);
        
        // Event listeners ekle
        this.addFieldEventListeners(field, fieldData);
        
        formData.fields.set(fieldId, fieldData);
    }

    /**
     * Field ile label'ı ilişkilendir
     */
    associateFieldWithLabel(field, fieldData) {
        let label = null;
        
        // 1. for attribute ile
        if (field.id) {
            label = document.querySelector(`label[for="${field.id}"]`);
        }
        
        // 2. Parent label
        if (!label) {
            label = field.closest('label');
        }
        
        // 3. Aria-labelledby ile
        if (!label && field.getAttribute('aria-labelledby')) {
            const labelledBy = field.getAttribute('aria-labelledby');
            label = document.getElementById(labelledBy);
        }
        
        if (label) {
            fieldData.label = label;
            
            // Label'ı iyileştir
            if (!label.id) {
                label.id = `label-${fieldData.id}`;
            }
            
            field.setAttribute('aria-labelledby', label.id);
        } else {
            // Label yoksa placeholder kullan
            const placeholder = field.getAttribute('placeholder');
            if (placeholder) {
                field.setAttribute('aria-label', placeholder);
            }
        }
    }

    /**
     * Field ile description'ı ilişkilendir
     */
    associateFieldWithDescription(field, fieldData) {
        // Help text ara
        let description = null;
        
        // aria-describedby ile
        if (field.getAttribute('aria-describedby')) {
            const describedBy = field.getAttribute('aria-describedby');
            description = document.getElementById(describedBy);
        }
        
        // Parent container'da help text ara
        if (!description) {
            const parent = field.closest('.form-group, .mb-3, .field-group');
            if (parent) {
                description = parent.querySelector('.help-text, .form-help, small.text-muted');
            }
        }
        
        if (description) {
            fieldData.description = description;
            
            if (!description.id) {
                description.id = `description-${fieldData.id}`;
            }
            
            // Mevcut describedby'ye ekle
            const currentDescribedBy = field.getAttribute('aria-describedby') || '';
            const newDescribedBy = currentDescribedBy ? `${currentDescribedBy} ${description.id}` : description.id;
            field.setAttribute('aria-describedby', newDescribedBy);
        }
    }

    /**
     * Field ARIA attributes ekle
     */
    addFieldAttributes(field, fieldData) {
        field.setAttribute('data-accessibility-field', 'true');
        field.setAttribute('data-field-id', fieldData.id);
        field.setAttribute('aria-invalid', 'false');
        
        // Required field için
        if (field.hasAttribute('required')) {
            field.setAttribute('aria-required', 'true');
            
            // Required asterisk ekle label'a
            if (fieldData.label) {
                this.addRequiredIndicator(fieldData.label);
            }
        }
        
        // Field type için özel ARIA
        if (field.type === 'email') {
            field.setAttribute('inputmode', 'email');
        } else if (field.type === 'tel') {
            field.setAttribute('inputmode', 'tel');
        } else if (field.type === 'url') {
            field.setAttribute('inputmode', 'url');
        } else if (field.type === 'number') {
            field.setAttribute('inputmode', 'decimal');
        }
    }

    /**
     * Required indicator ekle
     */
    addRequiredIndicator(label) {
        if (!label.querySelector('.required-indicator')) {
            const indicator = document.createElement('span');
            indicator.className = 'required-indicator text-red-500 ml-1';
            indicator.textContent = '*';
            indicator.setAttribute('aria-label', 'zorunlu alan');
            indicator.setAttribute('title', 'Bu alan zorunludur');
            
            // Label'ın sonuna ekle
            if (label.childNodes.length > 0) {
                label.appendChild(indicator);
            } else {
                label.appendChild(document.createTextNode(' '));
                label.appendChild(indicator);
            }
        }
    }

    /**
     * Field styling ekle
     */
    addFieldStyling(field, fieldData) {
        // Hata state styling
        if (!field.hasAttribute('data-error-styling')) {
            const style = document.createElement('style');
            style.textContent = `
                [data-accessibility-field].has-error {
                    border-color: #ef4444 !important;
                    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
                }
                [data-accessibility-field].has-success {
                    border-color: #10b981 !important;
                    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
                }
                [data-accessibility-field]:focus {
                    outline: 3px solid #3b82f6 !important;
                    outline-offset: 2px !important;
                }
            `;
            document.head.appendChild(style);
            field.setAttribute('data-error-styling', 'true');
        }
    }

    /**
     * Field event listeners ekle
     */
    addFieldEventListeners(field, fieldData) {
        // Focus events
        field.addEventListener('focus', () => {
            this.handleFieldFocus(field, fieldData);
        });
        
        field.addEventListener('blur', () => {
            this.handleFieldBlur(field, fieldData);
        });
        
        // Input events
        field.addEventListener('input', () => {
            this.handleFieldInput(field, fieldData);
        });
        
        field.addEventListener('change', () => {
            this.handleFieldChange(field, fieldData);
        });
        
        // Key events
        field.addEventListener('keydown', (event) => {
            this.handleFieldKeydown(event, field, fieldData);
        });
    }

    /**
     * Field focus handler
     */
    handleFieldFocus(field, fieldData) {
        // Error mesajlarını gizle
        this.hideFieldError(field, fieldData);
        
        // Focus announcement
        const fieldLabel = this.getFieldLabel(field);
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(`${fieldLabel} alanına odaklanıldı`, 'status_update');
        }
        
        // ARIA live region'da field bilgisi göster
        const formId = fieldData.form.id;
        const description = document.getElementById(`description-${fieldData.id}`);
        if (description) {
            const liveRegion = document.getElementById(`form-description-${formId}`);
            if (liveRegion) {
                liveRegion.textContent = description.textContent;
            }
        }
    }

    /**
     * Field blur handler
     */
    handleFieldBlur(field, fieldData) {
        // Validation yap
        this.validateField(field, fieldData);
        
        // Success state kontrolü
        if (fieldData.hasError) {
            this.announceFieldError(field, fieldData);
        } else if (field.value.trim()) {
            this.announceFieldSuccess(field, fieldData);
        }
    }

    /**
     * Field input handler
     */
    handleFieldInput(field, fieldData) {
        // Real-time validation
        if (field.value.trim()) {
            this.validateField(field, fieldData);
        }
        
        // Character count için
        if (field.hasAttribute('maxlength')) {
            this.updateCharacterCount(field, fieldData);
        }
    }

    /**
     * Field change handler
     */
    handleFieldChange(field, fieldData) {
        // Select field'lar için
        if (field.tagName === 'SELECT') {
            this.announceSelection(field, fieldData);
        }
        
        // Checkbox/Radio için
        if (field.type === 'checkbox' || field.type === 'radio') {
            this.announceToggle(field, fieldData);
        }
    }

    /**
     * Field keydown handler
     */
    handleFieldKeydown(event, field, fieldData) {
        // Enter tuşu - form submit
        if (event.key === 'Enter' && field.tagName !== 'TEXTAREA') {
            const form = field.closest('form');
            if (form) {
                event.preventDefault();
                
                // Sonraki field'a geç veya submit et
                const nextField = this.getNextField(field);
                if (nextField) {
                    nextField.focus();
                } else {
                    this.submitForm(form);
                }
            }
        }
        
        // Escape tuşu
        if (event.key === 'Escape') {
            // Form'u reset'le
            if (field.type !== 'submit') {
                this.resetField(field, fieldData);
            }
        }
    }

    /**
     * Validation kurulumu
     */
    setupValidation() {
        // Built-in validation rules
        this.addValidationRule('required', {
            validate: (value) => value.trim().length > 0,
            message: {
                tr: 'Bu alan zorunludur.',
                en: 'This field is required.'
            }
        });
        
        this.addValidationRule('email', {
            validate: (value) => {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(value);
            },
            message: {
                tr: 'Geçerli bir email adresi giriniz.',
                en: 'Please enter a valid email address.'
            }
        });
        
        this.addValidationRule('min', {
            validate: (value, min) => value.length >= min,
            message: {
                tr: (min) => `En az ${min} karakter giriniz.`,
                en: (min) => `Minimum ${min} characters required.`
            }
        });
        
        this.addValidationRule('max', {
            validate: (value, max) => value.length <= max,
            message: {
                tr: (max) => `En fazla ${max} karakter girebilirsiniz.`,
                en: (max) => `Maximum ${max} characters allowed.`
            }
        });
        
        this.addValidationRule('numeric', {
            validate: (value) => !isNaN(value) && !isNaN(parseFloat(value)),
            message: {
                tr: 'Sadece sayısal değer girebilirsiniz.',
                en: 'Only numeric values are allowed.'
            }
        });
    }

    /**
     * Validation rule ekle
     */
    addValidationRule(name, rule) {
        this.validationRules.set(name, rule);
    }

    /**
     * Real-time validation kur
     */
    setupRealTimeValidation(form, formData) {
        // Livewire form validation için
        if (form.hasAttribute('wire:submit')) {
            // Livewire events dinle
            if (window.Livewire) {
                Livewire.on('validation-error', (errors) => {
                    this.displayValidationErrors(formData, errors);
                });
                
                Livewire.on('form-success', (message) => {
                    this.displayFormSuccess(formData, message);
                });
            }
        }
    }

    /**
     * Field validation
     */
    validateField(field, fieldData) {
        const value = field.value.trim();
        const rules = this.getFieldRules(field);
        const errors = [];
        
        rules.forEach(rule => {
            const ruleObj = this.validationRules.get(rule.name);
            if (ruleObj) {
                const isValid = ruleObj.validate(value, rule.param);
                if (!isValid) {
                    const message = typeof ruleObj.message === 'function' 
                        ? ruleObj.message(rule.param)
                        : ruleObj.message[this.getCurrentLocale()] || ruleObj.message.en;
                    errors.push(message);
                }
            }
        });
        
        // Custom validation (data-val-* attributes)
        const customErrors = this.validateCustomRules(field, value);
        errors.push(...customErrors);
        
        // Error state güncelle
        if (errors.length > 0) {
            this.setFieldError(field, fieldData, errors);
        } else {
            this.clearFieldError(field, fieldData);
        }
        
        return errors.length === 0;
    }

    /**
     * Field rules al
     */
    getFieldRules(field) {
        const rules = [];
        
        // HTML5 validation attributes
        if (field.hasAttribute('required')) {
            rules.push({ name: 'required' });
        }
        
        if (field.type === 'email') {
            rules.push({ name: 'email' });
        }
        
        if (field.hasAttribute('minlength')) {
            rules.push({ name: 'min', param: parseInt(field.getAttribute('minlength')) });
        }
        
        if (field.hasAttribute('maxlength')) {
            rules.push({ name: 'max', param: parseInt(field.getAttribute('maxlength')) });
        }
        
        if (field.type === 'number') {
            rules.push({ name: 'numeric' });
        }
        
        // Data-val rules (ASP.NET MVC style)
        const dataVal = field.getAttribute('data-val');
        if (dataVal === 'true') {
            // data-val-required
            if (field.hasAttribute('data-val-required')) {
                rules.push({ name: 'required' });
            }
            
            // data-val-email
            if (field.hasAttribute('data-val-email')) {
                rules.push({ name: 'email' });
            }
            
            // data-val-length
            if (field.hasAttribute('data-val-length')) {
                const min = field.getAttribute('data-val-length-min');
                const max = field.getAttribute('data-val-length-max');
                if (min) rules.push({ name: 'min', param: parseInt(min) });
                if (max) rules.push({ name: 'max', param: parseInt(max) });
            }
        }
        
        return rules;
    }

    /**
     * Custom validation rules
     */
    validateCustomRules(field, value) {
        const errors = [];
        
        // Data-val-* rules
        if (field.hasAttribute('data-val-required')) {
            const message = field.getAttribute('data-val-required');
            if (!value) errors.push(message);
        }
        
        if (field.hasAttribute('data-val-email')) {
            const message = field.getAttribute('data-val-email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (value && !emailRegex.test(value)) {
                errors.push(message);
            }
        }
        
        if (field.hasAttribute('data-val-length')) {
            const min = parseInt(field.getAttribute('data-val-length-min')) || 0;
            const max = parseInt(field.getAttribute('data-val-length-max')) || Infinity;
            const message = field.getAttribute('data-val-length') || 'Length validation failed';
            
            if (value.length < min || value.length > max) {
                errors.push(message);
            }
        }
        
        return errors;
    }

    /**
     * Field error set et
     */
    setFieldError(field, fieldData, errors) {
        fieldData.hasError = true;
        field.setAttribute('aria-invalid', 'true');
        field.classList.add('has-error');
        field.classList.remove('has-success');
        
        // Error mesaj elementi oluştur
        const errorElement = this.createErrorElement(fieldData, errors);
        fieldData.errorElements.set('main', errorElement);
        
        // Field'a error container ekle
        this.addErrorElementToField(field, errorElement);
        
        // Form-level error update
        this.updateFormErrorState(fieldData.form);
    }

    /**
     * Field error'u temizle
     */
    clearFieldError(field, fieldData) {
        fieldData.hasError = false;
        field.setAttribute('aria-invalid', 'false');
        field.classList.remove('has-error');
        field.classList.add('has-success');
        
        // Error elementlerini kaldır
        fieldData.errorElements.forEach(errorEl => {
            if (errorEl.parentNode) {
                errorEl.parentNode.removeChild(errorEl);
            }
        });
        fieldData.errorElements.clear();
        
        // Form-level error state güncelle
        this.updateFormErrorState(fieldData.form);
    }

    /**
     * Field error'u gizle
     */
    hideFieldError(field, fieldData) {
        fieldData.errorElements.forEach(errorEl => {
            errorEl.style.display = 'none';
        });
    }

    /**
     * Error element oluştur
     */
    createErrorElement(fieldData, errors) {
        const errorElement = document.createElement('div');
        errorElement.className = 'field-error-message text-red-600 text-sm mt-1';
        errorElement.id = `error-${fieldData.id}`;
        errorElement.setAttribute('role', 'alert');
        errorElement.setAttribute('aria-live', 'polite');
        errorElement.setAttribute('data-error-for', fieldData.id);
        
        errorElement.innerHTML = `
            <ul class="error-list">
                ${errors.map(error => `<li>${error}</li>`).join('')}
            </ul>
        `;
        
        return errorElement;
    }

    /**
     * Error element'ini field'a ekle
     */
    addErrorElementToField(field, errorElement) {
        // Field'dan sonraki ilk sibling'e ekle
        let container = field.nextElementSibling;
        if (!container || !container.classList.contains('error-container')) {
            container = document.createElement('div');
            container.className = 'error-container';
            field.parentNode.insertBefore(container, field.nextSibling);
        }
        
        container.appendChild(errorElement);
    }

    /**
     * Form error state güncelle
     */
    updateFormErrorState(formData) {
        const hasErrors = Array.from(formData.fields.values()).some(field => field.hasError);
        const errorContainer = document.getElementById(`form-errors-${formData.id}`);
        
        if (hasErrors) {
            formData.element.classList.add('has-errors');
            if (errorContainer) {
                const errorCount = Array.from(formData.fields.values()).filter(field => field.hasError).length;
                errorContainer.textContent = `Formda ${errorCount} hata bulundu. Lütfen düzeltin ve tekrar deneyin.`;
            }
        } else {
            formData.element.classList.remove('has-errors');
            if (errorContainer) {
                errorContainer.textContent = '';
            }
        }
    }

    /**
     * Field error announcement
     */
    announceFieldError(field, fieldData) {
        const fieldLabel = this.getFieldLabel(field);
        const errorElement = fieldData.errorElements.get('main');
        const errorMessage = errorElement ? errorElement.textContent : 'Hata oluştu';
        
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announceFormError(fieldLabel, errorMessage);
        }
    }

    /**
     * Field success announcement
     */
    announceFieldSuccess(field, fieldData) {
        const fieldLabel = this.getFieldLabel(field);
        
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announceFormSuccess(fieldLabel + ' alanı doğru dolduruldu');
        }
    }

    /**
     * Selection announcement
     */
    announceSelection(field, fieldData) {
        const selectedOption = field.options[field.selectedIndex];
        const fieldLabel = this.getFieldLabel(field);
        const selectionText = selectedOption ? selectedOption.text : '';
        
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(`${fieldLabel} seçimi yapıldı: ${selectionText}`, 'status_update');
        }
    }

    /**
     * Toggle announcement
     */
    announceToggle(field, fieldData) {
        const fieldLabel = this.getFieldLabel(field);
        const isChecked = field.checked;
        
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(
                `${fieldLabel} ${isChecked ? 'seçildi' : 'seçim kaldırıldı'}`,
                'status_update'
            );
        }
    }

    /**
     * Character count güncelle
     */
    updateCharacterCount(field, fieldData) {
        const maxLength = parseInt(field.getAttribute('maxlength'));
        const currentLength = field.value.length;
        const remaining = maxLength - currentLength;
        
        // Character counter element oluştur
        let counter = field.parentNode.querySelector('.character-counter');
        if (!counter) {
            counter = document.createElement('div');
            counter.className = 'character-counter text-xs text-gray-500 mt-1';
            counter.setAttribute('aria-live', 'polite');
            field.parentNode.appendChild(counter);
        }
        
        counter.textContent = `${currentLength}/${maxLength} karakter`;
        
        if (remaining < 10) {
            counter.className = 'character-counter text-xs text-yellow-600 mt-1';
        } else {
            counter.className = 'character-counter text-xs text-gray-500 mt-1';
        }
        
        // Critical limit uyarısı
        if (remaining <= 0) {
            if (window.LiveAnnouncer) {
                window.LiveAnnouncer.announce('Maksimum karakter sınırına ulaşıldı', 'form_error');
            }
        }
    }

    /**
     * Field reset
     */
    resetField(field, fieldData) {
        // Value'yu temizle
        field.value = '';
        
        // Error state'i temizle
        this.clearFieldError(field, fieldData);
        
        // Character counter'u temizle
        const counter = field.parentNode.querySelector('.character-counter');
        if (counter) {
            counter.remove();
        }
        
        // Announcement
        const fieldLabel = this.getFieldLabel(field);
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(`${fieldLabel} alanı temizlendi`, 'status_update');
        }
    }

    /**
     * Form submission iyileştir
     */
    enhanceFormSubmission(form, formData) {
        // Submit button bul
        const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
        
        if (submitButton) {
            // Submit button'a ARIA attributes ekle
            if (!submitButton.id) {
                submitButton.id = `submit-${formData.id}`;
            }
            
            form.setAttribute('aria-describedby', 
                `${form.getAttribute('aria-describedby')} submit-${formData.id}`
            );
            
            // Submit announcement
            if (window.LiveAnnouncer) {
                window.LiveAnnouncer.announce('Form gönderim butonuna odaklandınız', 'status_update');
            }
        }
        
        // Form submit event
        form.addEventListener('submit', (event) => {
            this.handleFormSubmit(event, formData);
        });
    }

    /**
     * Form submit handler
     */
    handleFormSubmit(event, formData) {
        // Tüm field'ları validate et
        let isValid = true;
        formData.fields.forEach((fieldData, fieldId) => {
            const field = fieldData.element;
            if (!this.validateField(field, fieldData)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            event.preventDefault();
            
            // İlk hatalı field'a odaklan
            const firstErrorField = Array.from(formData.fields.values())
                .find(fieldData => fieldData.hasError);
            
            if (firstErrorField) {
                firstErrorField.element.focus();
            }
            
            // Form error announcement
            if (window.LiveAnnouncer) {
                const errorCount = Array.from(formData.fields.values())
                    .filter(field => field.hasError).length;
                window.LiveAnnouncer.announce(
                    `Form gönderilemedi. ${errorCount} hata bulundu.`,
                    'form_error'
                );
            }
            
            return false;
        }
        
        // Success case
        formData.submitted = true;
        
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announceFormSuccess('Form başarıyla gönderildi');
        }
    }

    /**
     * Form success mesajı göster
     */
    displayFormSuccess(formData, message = null) {
        const successContainer = document.getElementById(`form-success-${formData.id}`);
        if (successContainer) {
            successContainer.textContent = message || 'Form başarıyla gönderildi.';
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                successContainer.textContent = '';
            }, 5000);
        }
        
        // Visual success indicator
        formData.element.classList.add('form-success');
    }

    /**
     * Validation errors göster
     */
    displayValidationErrors(formData, errors) {
        // Laravel Livewire validation errors format
        Object.entries(errors).forEach(([fieldName, fieldErrors]) => {
            // Field'ı bul
            let field = formData.element.querySelector(`[name="${fieldName}"]`);
            if (!field) {
                field = formData.element.querySelector(`#${fieldName}`);
            }
            
            if (field) {
                const fieldData = Array.from(formData.fields.values())
                    .find(fd => fd.element === field);
                    
                if (fieldData) {
                    const errorMessages = Array.isArray(fieldErrors) ? fieldErrors : [fieldErrors];
                    this.setFieldError(field, fieldData, errorMessages);
                }
            }
        });
        
        // Form level error
        const errorContainer = document.getElementById(`form-errors-${formData.id}`);
        if (errorContainer) {
            errorContainer.textContent = 'Form validasyon hataları düzeltilmeli.';
        }
    }

    /**
     * Modal iyileştirmelerini kur
     */
    setupModalEnhancements() {
        document.addEventListener('click', (event) => {
            // Modal açma butonu kontrolü
            if (event.target.matches('[data-toggle="modal"], [data-bs-toggle="modal"]')) {
                this.handleModalOpen(event);
            }
            
            // Modal kapatma butonu kontrolü
            if (event.target.matches('[data-dismiss="modal"], .modal-close, [data-bs-dismiss="modal"]')) {
                this.handleModalClose(event);
            }
        });
        
        // Escape key ile modal kapatma
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && this.currentModal) {
                this.closeModal(this.currentModal);
            }
        });
    }

    /**
     * Modal açma handler
     */
    handleModalOpen(event) {
        const trigger = event.target;
        const targetId = trigger.getAttribute('data-target') || trigger.getAttribute('data-bs-target');
        
        if (!targetId) return;
        
        const modal = document.querySelector(targetId);
        if (!modal) return;
        
        this.openModal(modal, trigger);
    }

    /**
     * Modal kapatma handler
     */
    handleModalClose(event) {
        const modal = event.target.closest('.modal, [role="dialog"]');
        if (modal) {
            this.closeModal(modal);
        }
    }

    /**
     * Modal aç
     */
    openModal(modal, trigger = null) {
        const modalId = this.generateModalId(modal);
        
        // Current modal'ı kaydet
        this.currentModal = modal;
        
        // Modal'ı iyileştir
        this.enhanceModal(modal, modalId);
        
        // Focus trap başlat
        if (window.AccessibilityUtils) {
            window.AccessibilityUtils.startFocusTrap(modal, {
                initialFocus: modal.querySelector('.modal-close, [data-dismiss="modal"]'),
                trapStack: true
            });
        }
        
        // Modal announce
        const modalTitle = this.getModalTitle(modal);
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announceModalOpen(modalTitle);
        }
        
        // Trap previous focus
        this.focusHistory.push(document.activeElement);
        
        // Event emit
        modal.dispatchEvent(new CustomEvent('modal:opened', { 
            detail: { modal, trigger }
        }));
    }

    /**
     * Modal kapat
     */
    closeModal(modal) {
        const modalId = modal.getAttribute('data-modal-id');
        
        // Focus trap'ten çık
        if (window.AccessibilityUtils) {
            window.AccessibilityUtils.exitFocusTrap();
        }
        
        // Previous focus'a dön
        const previousFocus = this.focusHistory.pop();
        if (previousFocus && previousFocus.focus) {
            setTimeout(() => {
                previousFocus.focus();
            }, 100);
        }
        
        // Current modal'ı temizle
        if (this.currentModal === modal) {
            this.currentModal = null;
        }
        
        // Event emit
        modal.dispatchEvent(new CustomEvent('modal:closed'));
    }

    /**
     * Modal iyileştir
     */
    enhanceModal(modal, modalId) {
        // Modal attributes
        modal.setAttribute('data-modal-id', modalId);
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-modal', 'true');
        
        // Title element'ini bul
        const titleElement = this.getModalTitleElement(modal);
        if (titleElement) {
            if (!titleElement.id) {
                titleElement.id = `modal-title-${modalId}`;
            }
            modal.setAttribute('aria-labelledby', titleElement.id);
        } else {
            // Title yoksa label ekle
            const title = this.getModalTitle(modal);
            modal.setAttribute('aria-label', title);
        }
        
        // Description ekle
        const description = modal.querySelector('.modal-description, .modal-body p:first-child');
        if (description) {
            if (!description.id) {
                description.id = `modal-description-${modalId}`;
            }
            modal.setAttribute('aria-describedby', description.id);
        }
        
        // Close button accessibility
        const closeButtons = modal.querySelectorAll('.modal-close, [data-dismiss="modal"], .btn-close');
        closeButtons.forEach(button => {
            if (!button.getAttribute('aria-label')) {
                const locale = document.documentElement.lang || 'tr';
                button.setAttribute('aria-label', locale === 'tr' ? 'Modalı kapat' : 'Close modal');
            }
            button.setAttribute('role', 'button');
        });
        
        // Focusable elements'leri güncelle
        this.updateModalFocusableElements(modal);
    }

    /**
     * Modal title al
     */
    getModalTitle(modal) {
        const titleElement = this.getModalTitleElement(modal);
        return titleElement ? titleElement.textContent.trim() : 'Modal Dialog';
    }

    /**
     * Modal title element'ini al
     */
    getModalTitleElement(modal) {
        return modal.querySelector('.modal-title, h1, h2, h3, [role="heading"]');
    }

    /**
     * Modal focusable elements güncelle
     */
    updateModalFocusableElements(modal) {
        const focusableElements = modal.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        focusableElements.forEach((element, index) => {
            if (!element.hasAttribute('tabindex')) {
                element.setAttribute('tabindex', '0');
            }
            
            // First focusable element'i belirle
            if (index === 0) {
                element.setAttribute('data-modal-first-focus', 'true');
            }
            
            // Last focusable element'i belirle
            if (index === focusableElements.length - 1) {
                element.setAttribute('data-modal-last-focus', 'true');
            }
        });
    }

    /**
     * Helper methods
     */
    getFieldLabel(field) {
        // Associated label
        if (field.id) {
            const label = document.querySelector(`label[for="${field.id}"]`);
            if (label) return label.textContent.trim();
        }
        
        // Parent label
        const parentLabel = field.closest('label');
        if (parentLabel) return parentLabel.textContent.trim();
        
        // aria-label
        const ariaLabel = field.getAttribute('aria-label');
        if (ariaLabel) return ariaLabel;
        
        // placeholder
        const placeholder = field.getAttribute('placeholder');
        if (placeholder) return placeholder;
        
        return field.name || field.id || 'Field';
    }

    getNextField(currentField) {
        const form = currentField.closest('form');
        if (!form) return null;
        
        const fields = Array.from(form.querySelectorAll(
            'input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled])'
        ));
        
        const currentIndex = fields.indexOf(currentField);
        return currentIndex >= 0 && currentIndex < fields.length - 1 ? fields[currentIndex + 1] : null;
    }

    getCurrentLocale() {
        return document.documentElement.lang || 'tr';
    }

    generateFormId(form) {
        return 'form_' + (form.id || Math.random().toString(36).substr(2, 9));
    }

    generateFieldId(field) {
        return field.id || 'field_' + Math.random().toString(36).substr(2, 9);
    }

    generateModalId(modal) {
        return modal.id || 'modal_' + Math.random().toString(36).substr(2, 9);
    }

    /**
     * Form submit trigger
     */
    submitForm(form) {
        const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitButton) {
            submitButton.click();
        } else {
            form.submit();
        }
    }

    /**
     * Event binding
     */
    bindEvents() {
        // Livewire events
        if (window.Livewire) {
            Livewire.on('validation-error', (data) => {
                const form = document.querySelector(`[data-form-id="${data.formId}"]`);
                if (form) {
                    const formData = this.forms.get(form);
                    if (formData) {
                        this.displayValidationErrors(formData, data.errors);
                    }
                }
            });
            
            Livewire.on('form-success', (data) => {
                const form = document.querySelector(`[data-form-id="${data.formId}"]`);
                if (form) {
                    const formData = this.forms.get(form);
                    if (formData) {
                        this.displayFormSuccess(formData, data.message);
                    }
                }
            });
        }
        
        // Custom events
        document.addEventListener('accessibility-enhance-form', (event) => {
            const form = event.detail.form;
            this.enhanceForm(form);
        });
        
        document.addEventListener('accessibility-open-modal', (event) => {
            const modal = event.detail.modal;
            this.openModal(modal, event.detail.trigger);
        });
    }

    /**
     * Reset method
     */
    reset() {
        this.forms.clear();
        this.modals.clear();
        this.focusHistory = [];
        this.currentForm = null;
        this.currentModal = null;
    }

    /**
     * Status get
     */
    getStatus() {
        return {
            formsCount: this.forms.size,
            modalsCount: this.modals.size,
            currentModal: this.currentModal ? this.currentModal.id : null,
            focusHistoryLength: this.focusHistory.length
        };
    }
}

// Global instance
window.AccessibleFormModal = new AccessibleFormModal();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AccessibleFormModal;
}