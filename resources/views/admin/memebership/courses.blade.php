@extends('layouts.admin', ['title' => 'Kurs Yönetimi'])

@section('content')
<div class="space-y-6" x-data="courseManager()">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kurs Yönetimi</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Oluşturduğunuz tüm kursları listeleyin ve yönetin</p>
        </div>
        <div>
            <button @click="addCourseModal = true"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                <x-heroicon name="plus" class="h-4 w-4 mr-2" />
                Yeni Kurs Oluştur
            </button>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />
                        <!-- Modal -->
                        <div class="modal fade" tabindex="-1" id="adduser" aria-h6ledby="exampleModalh6"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header ">
                                        <h3 class="mb-2 d-inline ">Add Course</h3>
                                        <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body ">
                                        <div>
                                            <form method="POST" action="{{ route('addcourse') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <h6 class="">Course Category</h6>
                                                        <select name="category" id="" class="form-control  ">
                                                            <option value="Null">Null</option>
                                                            @foreach ($categories as $cat)
                                                                <option value="{{ $cat->category }}">{{ $cat->category }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <h6 class="">Course Title</h6>
                                                        <input type="text" class="form-control  " name="title"
                                                            required>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <h6 class="">Description</h6>
                                                        <textarea name="desc" id="" cols="4" class="form-control  " required></textarea>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <h6 class="">Amount
                                                            {{ $settings->currency }}
                                                        </h6>
                                                        <input type="number" class="form-control  " name="amount">
                                                        <span class=" mt-2"> Enter amount a user
                                                            can
                                                            pay to
                                                            get this course. If empty the course will
                                                            be available for free.
                                                        </span>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <h6 class="">Course Image (File)</h6>
                                                        <input type="file" class="form-control  " name="image">

                                                        @error('image')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <h6 class="">Course Image (Url)</h6>
                                                        <input type="text" class="form-control  " name="image_url">
                                                    </div>
                                                    <h6 class="">Use either file upload or url to
                                                        choose a course image, if both is entered, the file upload will be
                                                        used.
                                                    </h6>
                                                </div>
                                                <button type="submit" class="px-4 btn btn-primary">Add Course</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End add user modal --}}
                    </div>
                </div>
    <!-- Courses Grid -->
    @if(count($courses->data) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($courses->data as $course)
                <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 overflow-hidden">
                    <!-- Course Image -->
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ str_starts_with($course->course->course_image, 'http') ? $course->course->course_image : asset('storage/' . $course->course->course_image) }}"
                             alt="{{ $course->course->course_title }}"
                             class="w-full h-48 object-cover">
                    </div>
                    
                    <!-- Course Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ $course->course->course_title }}
                        </h3>
                        
                        <div class="flex items-center justify-between mb-4">
                            <button @click="openEditModal({{ $course->course->id }}, '{{ $course->course->course_title }}', '{{ $course->course->description }}', '{{ $course->course->category }}', {{ $course->course->amount ?? 0 }}, '{{ $course->course->course_image }}')"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                <x-heroicon name="edit" class="w-3 h-3 mr-1" />
                                Düzenle
                            </button>
                            
                            <a href="{{ route('lessons', $course->course->id) }}"
                               class="inline-flex items-center text-sm text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                <x-heroicon name="book-open" class="w-4 h-4 mr-1" />
                                <span>{{ count($course->lessons) }} {{ count($course->lessons) > 1 ? 'Ders' : 'Ders' }}</span>
                                <x-heroicon name="external-link" class="w-3 h-3 ml-1" />
                            </a>
                        </div>
                        
                        <!-- Price -->
                        <div class="mb-4">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ !$course->course->amount ? 'Ücretsiz' : $settings->currency . number_format($course->course->amount, 2) }}
                            </span>
                        </div>
                        
                        <!-- Delete Button -->
                        <button @click="openDeleteModal({{ $course->course->id }}, '{{ $course->course->course_title }}')"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-admin-800">
                            <x-heroicon name="trash-2" class="w-4 h-4 mr-2" />
                            Kursu Sil
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-12 text-center">
            <div class="flex flex-col items-center">
                <x-heroicon name="book" class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" />
                <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Henüz kurs eklenmemiş</h3>
                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1 mb-4">İlk kursunuzu oluşturmak için başlayın.</p>
                <button @click="addCourseModal = true"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    <x-heroicon name="plus" class="h-4 w-4 mr-2" />
                    Kurs Ekle
                </button>
            </div>
        </div>
    @endif
</div>
<!-- Edit Course Modal -->
<div x-show="editCourseModal"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editCourseModal = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 sm:mx-0 sm:h-10 sm:w-10">
                    <x-heroicon name="edit" class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Kurs Düzenle</h3>
                    
                    <form method="POST" action="{{ route('updatecourse') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kurs Kategorisi</label>
                            <select name="category"
                                    x-model="editForm.category"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->category }}">{{ $cat->category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kurs Başlığı</label>
                            <input type="text"
                                   name="title"
                                   x-model="editForm.title"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Açıklama</label>
                            <textarea name="desc"
                                      rows="4"
                                      x-model="editForm.description"
                                      required
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fiyat ({{ $settings->currency }})</label>
                            <input type="number"
                                   step="0.01"
                                   name="amount"
                                   x-model="editForm.amount"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kurs Resmi (Dosya)</label>
                            <input type="file"
                                   name="image"
                                   accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('image')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kurs Resmi (URL)</label>
                            <input type="text"
                                   name="image_url"
                                   x-model="editForm.image"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <input type="hidden" name="course_id" x-model="editForm.id">

                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse space-y-2 sm:space-y-0 sm:space-x-reverse sm:space-x-3">
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800 sm:ml-3 sm:w-auto sm:text-sm">
                                Kursu Güncelle
                            </button>
                            <button type="button"
                                    @click="editCourseModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-admin-600 shadow-sm px-4 py-2 bg-white dark:bg-admin-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800 sm:mt-0 sm:w-auto sm:text-sm">
                                İptal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Course Modal -->
<div x-show="deleteCourseModal"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="deleteCourseModal = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                    <x-heroicon name="trash-2" class="h-6 w-6 text-red-600 dark:text-red-400" />
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Kursu Sil</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            "<span x-text="deleteForm.title"></span>" kursunu ve ilgili tüm derslerini silmek istediğinizden emin misiniz?
                            Bu işlem geri alınamaz.
                        </p>
                    </div>

                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse space-y-2 sm:space-y-0 sm:space-x-reverse sm:space-x-3">
                        <a :href="`{{ url('') }}/admin/deletecourse/${deleteForm.id}`"
                           class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-admin-800 sm:ml-3 sm:w-auto sm:text-sm">
                            SİL
                        </a>
                        <button type="button"
                                @click="deleteCourseModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-admin-600 shadow-sm px-4 py-2 bg-white dark:bg-admin-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800 sm:mt-0 sm:w-auto sm:text-sm">
                            İptal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function courseManager() {
    return {
        addCourseModal: false,
        editCourseModal: false,
        deleteCourseModal: false,
        
        editForm: {
            id: '',
            title: '',
            description: '',
            category: '',
            amount: '',
            image: ''
        },
        
        deleteForm: {
            id: '',
            title: ''
        },
        
        openEditModal(id, title, description, category, amount, image) {
            this.editForm = {
                id: id,
                title: title,
                description: description,
                category: category,
                amount: amount,
                image: image
            };
            this.editCourseModal = true;
        },
        
        openDeleteModal(id, title) {
            this.deleteForm = {
                id: id,
                title: title
            };
            this.deleteCourseModal = true;
        }
    }
}
</script>
@endsection
