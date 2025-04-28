/**
 * Quản lý chức năng tìm kiếm và quản lý chủ sở hữu với Alpine.js
 * 
 * @returns {Object} Các thuộc tính và phương thức cho Alpine.js data
 */
function ownerSearchData() {
    return {
        searchTerm: '',
        searchResults: [],
        selectedOwners: [],
        currentOwnerRole: 'Chủ sở hữu chính',
        isLoading: false,
        errorMessage: '',
        ownerRoles: [
            'Chủ sở hữu chính',
            'Đồng sở hữu',
            'Quản lý',
            'Nhân viên'
        ],
        
        /**
         * Khởi tạo dữ liệu từ giá trị hiện tại
         */
        init() {
            try {
                const ownersData = document.getElementById('existingOwnersData');
                if (ownersData && ownersData.value) {
                    this.selectedOwners = JSON.parse(ownersData.value);
                    // Đảm bảo danh sách được cập nhật ngay khi init
                    this.updateOwnersList();
                }
            } catch(e) {
                console.error('Lỗi khi parse dữ liệu owners:', e);
                this.selectedOwners = [];
            }
        },

        /**
         * Thực hiện tìm kiếm người dùng qua API
         */
        searchUsers() {
            if (!this.searchTerm.trim()) {
                this.errorMessage = 'Vui lòng nhập từ khóa tìm kiếm';
                return;
            }
            
            this.isLoading = true;
            this.errorMessage = '';
            this.searchResults = [];
            
            fetch(`/api/users/search?q=${encodeURIComponent(this.searchTerm)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Lọc bỏ những người dùng đã được thêm vào danh sách chủ sở hữu
                    this.searchResults = data.filter(user => 
                        !this.selectedOwners.some(owner => owner.id === user.id)
                    );
                    
                    this.isLoading = false;
                    if (this.searchResults.length === 0) {
                        this.errorMessage = 'Không tìm thấy kết quả nào hoặc người dùng đã được thêm';
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    this.isLoading = false;
                    this.errorMessage = 'Đã xảy ra lỗi khi tìm kiếm';
                });
        },
        
        /**
         * Thêm người dùng vào danh sách chủ sở hữu
         * 
         * @param {Object} user Thông tin người dùng cần thêm
         */
        selectUser(user) {
            // Tạo bản sao và thêm vai trò vào user
            const userWithRole = {
                ...user,
                role: this.currentOwnerRole
            };
            
            // Thêm vào danh sách
            this.selectedOwners.push(userWithRole);
            
            // Cập nhật danh sách chủ sở hữu trong input hidden
            this.updateOwnersList();
            
            // Xóa khỏi kết quả tìm kiếm và reset ô tìm kiếm
            this.searchResults = this.searchResults.filter(u => u.id !== user.id);
            this.searchTerm = '';
        },
        
        /**
         * Xóa chủ sở hữu khỏi danh sách
         * 
         * @param {number} ownerId ID của chủ sở hữu cần xóa
         */
        removeOwner(ownerId) {
            this.selectedOwners = this.selectedOwners.filter(owner => owner.id !== ownerId);
            this.updateOwnersList();
        },
        
        /**
         * Cập nhật danh sách chủ sở hữu vào input hidden
         */
        updateOwnersList() {
            const ownersInput = document.getElementById('ownersListInput');
            if (ownersInput) {
                ownersInput.value = JSON.stringify(this.selectedOwners);
            }
        },
        
        /**
         * Thay đổi vai trò của chủ sở hữu
         * 
         * @param {number} ownerId ID của chủ sở hữu
         * @param {string} newRole Vai trò mới
         */
        changeOwnerRole(ownerId, newRole) {
            const index = this.selectedOwners.findIndex(owner => owner.id === ownerId);
            if (index !== -1) {
                this.selectedOwners[index].role = newRole;
                this.updateOwnersList();
            }
        },
        
        /**
         * Xử lý phím Enter trong ô tìm kiếm
         * 
         * @param {KeyboardEvent} event Sự kiện bàn phím
         */
        handleKeyDown(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                this.searchUsers();
            }
        }
    };
}
