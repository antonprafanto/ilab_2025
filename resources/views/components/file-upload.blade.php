@props([
    'label' => null,
    'name' => '',
    'accept' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'multiple' => false,
    'maxSize' => '2MB',
    'preview' => true,
])

<div {{ $attributes->only('class') }} x-data="fileUpload()">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            type="file"
            id="{{ $name }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            @if($accept) accept="{{ $accept }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($multiple) multiple @endif
            @change="handleFiles($event)"
            class="hidden"
        />

        <label
            for="{{ $name }}"
            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer
                   {{ $error ? 'border-red-300 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800' }}
                   hover:bg-gray-100 dark:hover:bg-gray-700
                   {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        >
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    @if($accept)
                        {{ $accept }} (Max: {{ $maxSize }})
                    @else
                        Semua file (Max: {{ $maxSize }})
                    @endif
                </p>
            </div>
        </label>
    </div>

    @if($preview)
        <div x-show="files.length > 0" class="mt-4 space-y-2">
            <template x-for="(file, index) in files" :key="index">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <template x-if="file.type && file.type.startsWith('image/')">
                            <img :src="file.preview" class="w-12 h-12 object-cover rounded">
                        </template>
                        <template x-if="!file.type || !file.type.startsWith('image/')">
                            <div class="w-12 h-12 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </template>
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="file.name"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="formatFileSize(file.size)"></p>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="removeFile(index)"
                        class="text-red-500 hover:text-red-700"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    @endif

    @if($hint && !$error)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>

<script>
function fileUpload() {
    return {
        files: [],
        handleFiles(event) {
            const fileList = event.target.files;
            this.files = [];

            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.files.push({
                            name: file.name,
                            size: file.size,
                            type: file.type,
                            preview: e.target.result
                        });
                    };
                    reader.readAsDataURL(file);
                } else {
                    this.files.push({
                        name: file.name,
                        size: file.size,
                        type: file.type,
                        preview: null
                    });
                }
            }
        },
        removeFile(index) {
            this.files.splice(index, 1);
            document.getElementById('{{ $name }}').value = '';
        },
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
    }
}
</script>
