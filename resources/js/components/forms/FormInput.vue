<template>
  <div class="form-group">
    <!-- Label -->
    <label
      v-if="label"
      :for="inputId"
      :class="[
        'form-label',
        { 'required': required, 'optional': optional }
      ]"
    >
      {{ label }}
    </label>

    <!-- Input Container -->
    <div class="relative">
      <!-- Icon Left -->
      <div
        v-if="iconLeft"
        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
      >
        <i :class="['text-gray-400', iconLeft]"></i>
      </div>

      <!-- Input Field -->
      <input
        :id="inputId"
        ref="inputRef"
        :type="inputType"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        :autocomplete="autocomplete"
        :class="[
          'form-input',
          {
            'pl-10': iconLeft,
            'pr-10': iconRight || showPasswordToggle,
            'is-invalid': hasError,
            'is-valid': isValid && !hasError,
            'is-loading': loading
          },
          sizeClass
        ]"
        v-bind="$attrs"
        @input="handleInput"
        @blur="handleBlur"
        @focus="handleFocus"
        @keydown="handleKeydown"
      />

      <!-- Icon Right -->
      <div
        v-if="iconRight && !showPasswordToggle"
        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
      >
        <i :class="['text-gray-400', iconRight]"></i>
      </div>

      <!-- Password Toggle -->
      <button
        v-if="showPasswordToggle"
        type="button"
        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
        @click="togglePasswordVisibility"
      >
        <i :class="passwordVisible ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
      </button>

      <!-- Clear Button -->
      <button
        v-if="clearable && modelValue && !disabled"
        type="button"
        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
        :class="{ 'pr-10': showPasswordToggle }"
        @click="clearInput"
      >
        <i class="fas fa-times"></i>
      </button>

      <!-- Loading Spinner -->
      <div
        v-if="loading"
        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
      >
        <i class="fas fa-spinner fa-spin text-gray-400"></i>
      </div>

      <!-- Validation Icon -->
      <div
        v-if="isValid && !hasError && !loading"
        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
      >
        <i class="fas fa-check text-green-500"></i>
      </div>

      <div
        v-if="hasError && !loading"
        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
      >
        <i class="fas fa-exclamation-circle text-red-500"></i>
      </div>
    </div>

    <!-- Help Text -->
    <div v-if="helpText" class="form-help">
      {{ helpText }}
    </div>

    <!-- Error Messages -->
    <div v-if="hasError" class="form-error">
      <div v-for="error in errors" :key="error">
        {{ error }}
      </div>
    </div>

    <!-- Success Message -->
    <div v-if="successMessage" class="form-success">
      {{ successMessage }}
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, computed, nextTick, watch } from 'vue'

/**
 * FormInput - Advanced form input component with validation and features
 * 
 * @component FormInput
 * @example
 * <FormInput
 *   v-model="email"
 *   type="email"
 *   label="Email Address"
 *   placeholder="Enter your email"
 *   :required="true"
 *   :errors="emailErrors"
 * />
 */
export default defineComponent({
  name: 'FormInput',
  inheritAttrs: false,
  props: {
    /**
     * Input value (v-model)
     */
    modelValue: {
      type: [String, Number],
      default: ''
    },
    /**
     * Input type
     */
    type: {
      type: String,
      default: 'text',
      validator: (value) => [
        'text', 'email', 'password', 'number', 'tel', 'url', 
        'search', 'date', 'datetime-local', 'time', 'month', 'week'
      ].includes(value)
    },
    /**
     * Input label
     */
    label: {
      type: String,
      default: ''
    },
    /**
     * Placeholder text
     */
    placeholder: {
      type: String,
      default: ''
    },
    /**
     * Help text displayed below input
     */
    helpText: {
      type: String,
      default: ''
    },
    /**
     * Error messages array
     */
    errors: {
      type: Array,
      default: () => []
    },
    /**
     * Success message
     */
    successMessage: {
      type: String,
      default: ''
    },
    /**
     * Input size
     */
    size: {
      type: String,
      default: 'base',
      validator: (value) => ['sm', 'base', 'lg'].includes(value)
    },
    /**
     * Left icon class
     */
    iconLeft: {
      type: String,
      default: ''
    },
    /**
     * Right icon class
     */
    iconRight: {
      type: String,
      default: ''
    },
    /**
     * Whether input is required
     */
    required: {
      type: Boolean,
      default: false
    },
    /**
     * Whether input is optional (shows optional text)
     */
    optional: {
      type: Boolean,
      default: false
    },
    /**
     * Whether input is disabled
     */
    disabled: {
      type: Boolean,
      default: false
    },
    /**
     * Whether input is readonly
     */
    readonly: {
      type: Boolean,
      default: false
    },
    /**
     * Whether input shows loading state
     */
    loading: {
      type: Boolean,
      default: false
    },
    /**
     * Whether input is clearable
     */
    clearable: {
      type: Boolean,
      default: false
    },
    /**
     * Autocomplete attribute
     */
    autocomplete: {
      type: String,
      default: ''
    },
    /**
     * Whether to auto-focus on mount
     */
    autofocus: {
      type: Boolean,
      default: false
    },
    /**
     * Debounce delay for input events (ms)
     */
    debounce: {
      type: Number,
      default: 0
    },
    /**
     * Validation rules object
     */
    rules: {
      type: Object,
      default: () => ({})
    }
  },
  emits: [
    /**
     * Emitted when input value changes
     * @event update:modelValue
     * @property {string|number} value - New input value
     */
    'update:modelValue',
    
    /**
     * Emitted on input focus
     * @event focus
     * @property {FocusEvent} event - Focus event
     */
    'focus',
    
    /**
     * Emitted on input blur
     * @event blur  
     * @property {FocusEvent} event - Blur event
     */
    'blur',
    
    /**
     * Emitted on keydown
     * @event keydown
     * @property {KeyboardEvent} event - Keyboard event
     */
    'keydown',
    
    /**
     * Emitted when input is cleared
     * @event clear
     */
    'clear'
  ],
  setup(props, { emit }) {
    // State
    const inputRef = ref(null)
    const passwordVisible = ref(false)
    const isFocused = ref(false)
    const debounceTimeout = ref(null)

    // Computed
    const inputId = computed(() => {
      return `input-${Math.random().toString(36).substr(2, 9)}`
    })

    const inputType = computed(() => {
      if (props.type === 'password' && passwordVisible.value) {
        return 'text'
      }
      return props.type
    })

    const showPasswordToggle = computed(() => {
      return props.type === 'password'
    })

    const hasError = computed(() => {
      return props.errors && props.errors.length > 0
    })

    const isValid = computed(() => {
      return props.modelValue && 
             props.modelValue.toString().length > 0 && 
             !hasError.value &&
             validateRules()
    })

    const sizeClass = computed(() => {
      const sizes = {
        sm: 'form-input-sm',
        base: '',
        lg: 'form-input-lg'
      }
      return sizes[props.size] || ''
    })

    // Methods
    const validateRules = () => {
      if (!props.rules || Object.keys(props.rules).length === 0) {
        return true
      }

      const value = props.modelValue
      
      // Required validation
      if (props.rules.required && (!value || value.toString().length === 0)) {
        return false
      }

      // Min length validation
      if (props.rules.minLength && value && value.toString().length < props.rules.minLength) {
        return false
      }

      // Max length validation
      if (props.rules.maxLength && value && value.toString().length > props.rules.maxLength) {
        return false
      }

      // Email validation
      if (props.rules.email && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        if (!emailRegex.test(value)) {
          return false
        }
      }

      // Pattern validation
      if (props.rules.pattern && value) {
        const regex = new RegExp(props.rules.pattern)
        if (!regex.test(value)) {
          return false
        }
      }

      return true
    }

    const handleInput = (event) => {
      const value = event.target.value

      if (props.debounce > 0) {
        if (debounceTimeout.value) {
          clearTimeout(debounceTimeout.value)
        }
        
        debounceTimeout.value = setTimeout(() => {
          emit('update:modelValue', value)
        }, props.debounce)
      } else {
        emit('update:modelValue', value)
      }
    }

    const handleFocus = (event) => {
      isFocused.value = true
      emit('focus', event)
    }

    const handleBlur = (event) => {
      isFocused.value = false
      emit('blur', event)
    }

    const handleKeydown = (event) => {
      emit('keydown', event)
      
      // Handle Enter key
      if (event.key === 'Enter') {
        // Submit form or trigger search
        const form = event.target.closest('form')
        if (form && props.type !== 'textarea') {
          form.dispatchEvent(new Event('submit', { cancelable: true }))
        }
      }
      
      // Handle Escape key
      if (event.key === 'Escape') {
        event.target.blur()
      }
    }

    const togglePasswordVisibility = () => {
      passwordVisible.value = !passwordVisible.value
    }

    const clearInput = () => {
      emit('update:modelValue', '')
      emit('clear')
      
      nextTick(() => {
        if (inputRef.value) {
          inputRef.value.focus()
        }
      })
    }

    const focus = () => {
      if (inputRef.value) {
        inputRef.value.focus()
      }
    }

    const blur = () => {
      if (inputRef.value) {
        inputRef.value.blur()
      }
    }

    const select = () => {
      if (inputRef.value) {
        inputRef.value.select()
      }
    }

    // Auto-focus on mount
    watch(() => props.autofocus, (shouldFocus) => {
      if (shouldFocus) {
        nextTick(() => {
          focus()
        })
      }
    }, { immediate: true })

    // Cleanup debounce on unmount
    const cleanup = () => {
      if (debounceTimeout.value) {
        clearTimeout(debounceTimeout.value)
      }
    }

    // Expose methods for template refs
    return {
      // Template refs
      inputRef,
      
      // State
      passwordVisible,
      isFocused,
      
      // Computed
      inputId,
      inputType,
      showPasswordToggle,
      hasError,
      isValid,
      sizeClass,
      
      // Methods
      handleInput,
      handleFocus,
      handleBlur,
      handleKeydown,
      togglePasswordVisibility,
      clearInput,
      focus,
      blur,
      select,
      cleanup
    }
  },
  beforeUnmount() {
    this.cleanup()
  }
})
</script>

<style scoped>
/* Component-specific styles are inherited from global form styles */
/* Additional component-specific customizations can be added here */

.form-group {
  position: relative;
}

/* Enhanced focus styles for better accessibility */
.form-input:focus-within {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

/* Smooth transitions for all interactions */
.form-input {
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Icon positioning adjustments */
.absolute i {
  font-size: 0.875rem;
}

/* Loading state animation */
.is-loading {
  background-image: url("data:image/svg+xml,%3csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3e%3cg fill='none' fill-rule='evenodd'%3e%3cg fill='%23D1D5DB'%3e%3cpath d='M10 3v3l4-4-4-4v3c-4.42 0-8 3.58-8 8s3.58 8 8 8c1.57 0 3.04-.46 4.28-1.25l1.45 1.45C14.03 18.2 12.12 19 10 19c-5.52 0-10-4.48-10-10s4.48-10 10-10z'/%3e%3c/g%3e%3c/g%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 0.75rem center;
  background-size: 1rem;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 640px) {
  .form-input {
    font-size: 16px; /* Prevent zoom on iOS */
  }
}
</style>