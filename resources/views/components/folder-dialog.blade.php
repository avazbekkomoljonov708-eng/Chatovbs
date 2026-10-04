{{-- Folder Dialog - Telegram uslubi, kompakt va yoqimli --}}

<div id="folderOverlay" class="fd-overlay">
    <div class="fd-modal">
        {{-- Sarlavha --}}
        <div class="fd-header">
            <h3>Folders</h3>
            <button class="fd-close" onclick="closeFolderDialog()">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Kontenti --}}
        <div class="fd-content">
            {{-- Mavjud papkalar --}}
            <div class="fd-list">
                <div class="fd-folder-item" data-folder="unread">
                    <div class="fd-folder-icon">📭</div>
                    <div class="fd-folder-text">
                        <strong>Unread</strong>
                        <span>173 chats</span>
                    </div>
                    <button class="fd-folder-delete" onclick="deleteFolder('unread')">
                        <svg viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14zM10 11v6M14 11v6"/></svg>
                    </button>
                </div>

                <div class="fd-folder-item" data-folder="personal">
                    <div class="fd-folder-icon">👤</div>
                    <div class="fd-folder-text">
                        <strong>Personal</strong>
                        <span>101 chats</span>
                    </div>
                    <button class="fd-folder-delete" onclick="deleteFolder('personal')">
                        <svg viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14zM10 11v6M14 11v6"/></svg>
                    </button>
                </div>

                <div class="fd-folder-item" data-folder="custom">
                    <div class="fd-folder-icon">📁</div>
                    <div class="fd-folder-text">
                        <strong>Custom</strong>
                        <span>5 chats</span>
                    </div>
                    <button class="fd-folder-delete" onclick="deleteFolder('custom')">
                        <svg viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14zM10 11v6M14 11v6"/></svg>
                    </button>
                </div>
            </div>

            {{-- Yangi papka tugmasi --}}
            <button class="fd-add-btn" onclick="showNewFolderForm()">
                <span>+</span>
                Create new folder
            </button>
        </div>

        {{-- Yangi papka formi (yashiringan) --}}
        <div id="newFolderForm" class="fd-form" style="display: none;">
            <div class="fd-form-header">
                <h4>New Folder</h4>
            </div>

            <div class="fd-form-body">
                {{-- Icon va nomi --}}
                <div class="fd-name-group">
                    <button class="fd-icon-selector" onclick="showIconPicker()">
                        <span id="selectedIcon">📁</span>
                        <span class="fd-edit-badge">✏️</span>
                    </button>
                    <input type="text" class="fd-name-input" placeholder="Folder name" id="folderNameInput">
                </div>

                {{-- Icon tanlagich (yashiringan) --}}
                <div id="iconPicker" class="fd-icon-picker" style="display: none;">
                    <div class="fd-icon-grid">
                        <button type="button" onclick="selectIcon('📁', this)">📁</button>
                        <button type="button" onclick="selectIcon('🎯', this)">🎯</button>
                        <button type="button" onclick="selectIcon('👥', this)">👥</button>
                        <button type="button" onclick="selectIcon('💬', this)">💬</button>
                        <button type="button" onclick="selectIcon('⭐', this)">⭐</button>
                        <button type="button" onclick="selectIcon('🔖', this)">🔖</button>
                    </div>
                </div>

                {{-- Suhbat turini tanlash --}}
                <div class="fd-section">
                    <label>Included chats</label>
                    <div class="fd-filter-tabs">
                        <button class="fd-tab active" onclick="filterChatType('all', this)">All</button>
                        <button class="fd-tab" onclick="filterChatType('personal', this)">Personal</button>
                        <button class="fd-tab" onclick="filterChatType('groups', this)">Groups</button>
                        <button class="fd-tab" onclick="filterChatType('channels', this)">Channels</button>
                    </div>
                    <div class="fd-chat-list">
                        {{-- Suhbat ro'yxati dinamik yuklanadi --}}
                    </div>
                </div>

                {{-- Rang tanlash --}}
                <div class="fd-section">
                    <label>Folder color</label>
                    <div class="fd-color-grid">
                        <button class="fd-color-btn" style="background: #f16565;" onclick="selectColor('#f16565', this)"></button>
                        <button class="fd-color-btn" style="background: #f9a825;" onclick="selectColor('#f9a825', this)"></button>
                        <button class="fd-color-btn" style="background: #30b0c7;" onclick="selectColor('#30b0c7', this)"></button>
                        <button class="fd-color-btn" style="background: #6bb938;" onclick="selectColor('#6bb938', this)"></button>
                        <button class="fd-color-btn" style="background: #ab75cd;" onclick="selectColor('#ab75cd', this)"></button>
                        <button class="fd-color-btn" style="background: #6ba3e5;" onclick="selectColor('#6ba3e5', this)"></button>
                    </div>
                </div>
            </div>

            {{-- Tugmalar --}}
            <div class="fd-form-actions">
                <button class="fd-btn-cancel" onclick="hideNewFolderForm()">Cancel</button>
                <button class="fd-btn-create" onclick="createFolder()">Create</button>
            </div>
        </div>
    </div>
</div>

<style>
/* ========== PAPKA DIALOGI - TELEGRAM USLUBI ========== */
#folderOverlay {
    position: fixed;
    inset: 0;
    z-index: 240;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(2px);
}

#folderOverlay.show {
    display: flex;
}

.fd-modal {
    width: 360px;
    max-height: 70vh;
    background: var(--ink-soft);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: slideUp 0.2s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Sarlavha */
.fd-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--line);
}

.fd-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    font-family: 'Sora', sans-serif;
}

.fd-close {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    color: var(--muted-on-dark);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.15s, color 0.15s;
}

.fd-close:hover {
    background: var(--ink-softer);
    color: var(--paper);
}

.fd-close svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 2;
}

/* Kontenti */
.fd-content {
    flex: 1;
    overflow-y: auto;
    padding: 8px 8px;
}

.fd-content::-webkit-scrollbar {
    width: 5px;
}

.fd-content::-webkit-scrollbar-thumb {
    background: var(--line);
    border-radius: 4px;
}

/* Papka ro'yxati */
.fd-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 12px;
}

.fd-folder-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s;
}

.fd-folder-item:hover {
    background: var(--ink-softer);
}

.fd-folder-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.fd-folder-text {
    flex: 1;
    min-width: 0;
}

.fd-folder-text strong {
    display: block;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--paper);
}

.fd-folder-text span {
    display: block;
    margin-top: 2px;
    font-size: 12px;
    color: var(--muted-on-dark);
}

.fd-folder-delete {
    width: 32px;
    height: 32px;
    padding: 0;
    border: none;
    background: transparent;
    color: var(--muted-on-dark);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.15s, color 0.15s;
    opacity: 0;
}

.fd-folder-item:hover .fd-folder-delete {
    opacity: 1;
}

.fd-folder-delete:hover {
    background: rgba(241, 101, 101, 0.15);
    color: var(--danger);
}

.fd-folder-delete svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    stroke-width: 2;
}

/* Yangi papka tugmasi */
.fd-add-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 10px 12px;
    border: 1.5px dashed var(--line);
    background: transparent;
    color: var(--teal);
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 13.5px;
    transition: all 0.15s;
    font-family: 'Inter', sans-serif;
}

.fd-add-btn:hover {
    background: rgba(45, 212, 191, 0.08);
    border-color: var(--teal);
}

.fd-add-btn span {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

/* ============= YANGI PAPKA FORMI ============= */
.fd-form {
    border-top: 1px solid var(--line);
    display: flex;
    flex-direction: column;
    max-height: 100%;
}

.fd-form-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--line);
}

.fd-form-header h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    font-family: 'Sora', sans-serif;
}

.fd-form-body {
    flex: 1;
    overflow-y: auto;
    padding: 16px 20px;
}

.fd-form-body::-webkit-scrollbar {
    width: 5px;
}

.fd-form-body::-webkit-scrollbar-thumb {
    background: var(--line);
    border-radius: 4px;
}

/* Nom va icon */
.fd-name-group {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    margin-bottom: 20px;
}

.fd-icon-selector {
    position: relative;
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border: 2px solid var(--line);
    background: var(--ink-softer);
    border-radius: 10px;
    cursor: pointer;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color 0.15s, background 0.15s;
}

.fd-icon-selector:hover {
    border-color: var(--teal);
    background: rgba(45, 212, 191, 0.08);
}

.fd-edit-badge {
    position: absolute;
    right: -4px;
    bottom: -4px;
    width: 18px;
    height: 18px;
    background: var(--teal);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    border: 2px solid var(--ink-soft);
}

.fd-name-input {
    flex: 1;
    padding: 10px 0;
    border: none;
    border-bottom: 2px solid var(--line);
    background: transparent;
    color: var(--paper);
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    outline: none;
    transition: border-color 0.15s;
}

.fd-name-input:focus {
    border-bottom-color: var(--teal);
}

.fd-name-input::placeholder {
    color: var(--muted-on-dark);
}

/* Icon picker */
.fd-icon-picker {
    margin: -8px 0 16px 0;
    padding: 12px;
    background: var(--ink-softer);
    border-radius: 8px;
}

.fd-icon-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 8px;
}

.fd-icon-grid button {
    aspect-ratio: 1;
    border: none;
    background: var(--ink);
    border-radius: 8px;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}

.fd-icon-grid button:hover {
    background: var(--line);
    transform: scale(1.05);
}

.fd-icon-grid button.selected {
    background: var(--teal);
    transform: scale(1.1);
}

/* Sektor */
.fd-section {
    margin-bottom: 18px;
}

.fd-section > label {
    display: block;
    margin-bottom: 8px;
    font-size: 12px;
    font-weight: 600;
    color: var(--muted-on-dark);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* Filter tablar */
.fd-filter-tabs {
    display: flex;
    gap: 6px;
    margin-bottom: 10px;
}

.fd-tab {
    padding: 6px 12px;
    border: 1px solid var(--line);
    background: transparent;
    color: var(--muted-on-dark);
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
}

.fd-tab:hover {
    border-color: var(--paper);
    color: var(--paper);
}

.fd-tab.active {
    background: var(--teal);
    border-color: var(--teal);
    color: var(--teal-ink);
}

/* Suhbat ro'yxati */
.fd-chat-list {
    max-height: 180px;
    overflow-y: auto;
    border: 1px solid var(--line);
    border-radius: 8px;
    background: var(--ink);
}

.fd-chat-list::-webkit-scrollbar {
    width: 4px;
}

.fd-chat-list::-webkit-scrollbar-thumb {
    background: var(--line);
    border-radius: 2px;
}

/* Rang tanlash */
.fd-color-grid {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.fd-color-btn {
    width: 36px;
    height: 36px;
    border: 2px solid transparent;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.15s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.fd-color-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.fd-color-btn.selected {
    border-color: var(--paper);
    box-shadow: 0 0 0 2px var(--ink-soft), 0 0 0 4px currentColor;
}

/* Tugmalar */
.fd-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    padding: 12px 20px;
    border-top: 1px solid var(--line);
}

.fd-btn-cancel,
.fd-btn-create {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.15s;
    font-family: 'Inter', sans-serif;
}

.fd-btn-cancel {
    background: transparent;
    color: var(--muted-on-dark);
    border: 1px solid var(--line);
}

.fd-btn-cancel:hover {
    background: var(--ink-softer);
    color: var(--paper);
}

.fd-btn-create {
    background: var(--teal);
    color: var(--teal-ink);
}

.fd-btn-create:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.fd-btn-create:active {
    transform: translateY(0);
}
</style>

<script>
function openFolderDialog() {
    document.getElementById('folderOverlay').classList.add('show');
}

function closeFolderDialog() {
    document.getElementById('folderOverlay').classList.remove('show');
    hideNewFolderForm();
}

function showNewFolderForm() {
    document.getElementById('newFolderForm').style.display = 'flex';
    document.getElementById('folderNameInput').focus();
}

function hideNewFolderForm() {
    document.getElementById('newFolderForm').style.display = 'none';
    document.getElementById('folderNameInput').value = '';
    document.getElementById('iconPicker').style.display = 'none';
}

function showIconPicker() {
    const picker = document.getElementById('iconPicker');
    picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
}

function selectIcon(icon, btn) {
    document.getElementById('selectedIcon').textContent = icon;
    document.querySelectorAll('.fd-icon-grid button').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
}

function selectColor(color, btn) {
    document.querySelectorAll('.fd-color-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
}

function filterChatType(type, btn) {
    document.querySelectorAll('.fd-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

function deleteFolder(folder) {
    if (confirm(`Delete "${folder}" folder?`)) {
        console.log('Deleted:', folder);
    }
}

function createFolder() {
    const name = document.getElementById('folderNameInput').value;
    if (!name.trim()) {
        alert('Folder name is required');
        return;
    }
    console.log('Created folder:', name);
    hideNewFolderForm();
}

// Close overlay qachon bosganda tashqarida
document.getElementById('folderOverlay')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) {
        closeFolderDialog();
    }
});
</script>
