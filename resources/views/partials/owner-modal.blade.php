<!-- Modal quản lý chủ sở hữu/vendor -->
<div class="modal fade" id="addOwnerModal" tabindex="-1" aria-labelledby="addOwnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOwnerModalLabel">Quản lý chủ sở hữu/vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" x-data="ownerSearchData()">
                <form id="ownerForm" action="{{ route('post.update-owner', $post->id) }}" method="POST">
                    @csrf

                    <!-- Danh sách chủ sở hữu hiện tại -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Danh sách chủ sở hữu/vendor</h6>

                        <div class="owner-list border rounded p-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                            <template x-if="selectedOwners.length === 0">
                                <div class="text-muted text-center py-3">Chưa có chủ sở hữu nào được thêm</div>
                            </template>

                            <div class="table-responsive" x-show="selectedOwners.length > 0">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">Ảnh</th>
                                            <th>Tên</th>
                                            <th>Vai trò</th>
                                            <th style="width: 80px">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(owner, index) in selectedOwners" :key="owner.id">
                                            <tr>
                                                <td>
                                                    <img :src="owner.avatar" class="rounded-circle" width="40" height="40"
                                                         onerror="this.onerror=null; this.src='{{ asset('image/default/default-group-avatar.jpg') }}';">
                                                </td>
                                                <td>
                                                    <div x-text="owner.name"></div>
                                                    <small class="text-muted" x-text="owner.email"></small>
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm"
                                                            x-model="owner.role"
                                                            @change="changeOwnerRole(owner.id, $event.target.value)">
                                                        <template x-for="role in ownerRoles" :key="role">
                                                            <option :value="role" x-text="role"></option>
                                                        </template>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            @click="removeOwner(owner.id)"
                                                            title="Xóa chủ sở hữu">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Thêm chủ sở hữu mới -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Thêm chủ sở hữu mới</h6>

                        <div class="mb-3">
                            <label for="currentOwnerRole" class="form-label">Vai trò khi thêm</label>
                            <select class="form-select" id="currentOwnerRole" x-model="currentOwnerRole">
                                <template x-for="role in ownerRoles" :key="role">
                                    <option :value="role" x-text="role"></option>
                                </template>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="ownerSearch" class="form-label">Tìm kiếm người dùng</label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="ownerSearch"
                                        placeholder="Nhập tên hoặc email"
                                        x-model="searchTerm"
                                        @keydown="handleKeyDown"
                                    >
                                    <button class="btn btn-outline-primary" type="button" @click="searchUsers">
                                        <i class="fas fa-search"></i> Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Kết quả tìm kiếm -->
                        <div class="mb-3">
                            <div class="list-group search-results-container" style="max-height: 250px; overflow-y: auto;">
                                <!-- Loading indicator -->
                                <div class="text-center p-3" x-show="isLoading">
                                    <i class="fas fa-spinner fa-spin"></i> Đang tìm kiếm...
                                </div>

                                <!-- Error message -->
                                <div class="text-center p-3 text-danger" x-show="errorMessage" x-text="errorMessage"></div>

                                <!-- Search results -->
                                <template x-for="user in searchResults" :key="user.id">
                                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center" @click.prevent="selectUser(user)">
                                        <img :src="user.avatar" class="rounded-circle me-2" width="40" height="40"
                                             onerror="this.onerror=null; this.src='{{ asset('image/default/default-group-avatar.jpg') }}';">
                                        <div>
                                            <div x-text="user.name"></div>
                                            <small class="text-muted" x-text="user.email"></small>
                                        </div>
                                        <span class="ms-auto badge rounded-pill bg-primary">
                                            <i class="fas fa-plus"></i> Thêm
                                        </span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden inputs -->
                    <input type="hidden" name="owners_list" id="ownersListInput" value="[]">

                    <!-- Để tương thích với hệ thống cũ - chỉ lưu owner chính -->
                    <input type="hidden" name="owner_id" id="ownerIdInput"
                        x-bind:value="selectedOwners.length > 0 ?
                            (selectedOwners.find(o => o.role === 'Chủ sở hữu chính')?.id || selectedOwners[0].id) : ''"
                    >

                    <!-- Init hidden data -->
                    <input type="hidden" id="existingOwnersData" value="{{ isset($post->owners) ? $post->owners->map(function($owner) {
                        return [
                            'id' => $owner->id,
                            'name' => $owner->name,
                            'email' => $owner->email,
                            'avatar' => $owner->avatar,
                            'role' => $owner->pivot->role ?? 'Chủ sở hữu chính'
                        ];
                    })->toJson() : '[]' }}">

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Kích hoạt Alpine.js nếu chưa được load trong trang -->
@push('scripts')
    @if(!request()->routeIs('dining.detail-dining'))
        <!-- Load owner search JavaScript và Alpine.js nếu chưa được load trong layout chính -->
        <script src="{{ asset('js/owner-search.js') }}"></script>
        @if(!in_array('alpine', session('scripts_loaded', [])))
            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
            @php
                session()->push('scripts_loaded', 'alpine');
            @endphp
        @endif
    @endif
@endpush
