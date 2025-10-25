@if($roles->count() > 0)
    <div class="role-tree-container" x-data="roleTreeManager()">
        <div class="space-y-2">
            @foreach($roles->where('parent_role_id', null) as $role)
                @include('admin.roles.partials.tree-node', ['role' => $role, 'level' => 0])
            @endforeach
        </div>
    </div>
@else
    <div class="text-center py-12">
        <div class="w-24 h-24 bg-admin-100 dark:bg-admin-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="git-branch" class="w-12 h-12 text-admin-400 dark:text-admin-500"></i>
        </div>
        <h3 class="text-lg font-medium text-admin-900 dark:text-white mb-2">Henüz Rol Oluşturulmamış</h3>
        <p class="text-admin-600 dark:text-admin-400 mb-6">Hiyerarşik rol yapısını oluşturmak için ilk rolü ekleyin.</p>
        <a href="{{ route('admin.roles.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-blue-500/25 transition-all duration-200">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            İlk Rolü Oluştur
        </a>
    </div>
@endif

<script>
function roleTreeManager() {
    return {
        expandedNodes: {},
        
        init() {
            // Initialize with root nodes expanded
            this.$nextTick(() => {
                lucide.createIcons();
            });
        },
        
        toggleNode(roleId) {
            this.expandedNodes[roleId] = !this.expandedNodes[roleId];
        },
        
        isExpanded(roleId) {
            return this.expandedNodes[roleId] === true;
        },
        
        expandAll() {
            document.querySelectorAll('[data-role-id]').forEach(node => {
                const roleId = node.getAttribute('data-role-id');
                this.expandedNodes[roleId] = true;
            });
        },
        
        collapseAll() {
            this.expandedNodes = {};
        }
    }
}
</script>