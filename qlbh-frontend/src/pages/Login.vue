<template>
  <div class="login-wrapper">
    <div class="login-container">
      <div class="login-sidebar">
        <div class="sidebar-content">
          <h1>ANIME NEI</h1>
          <p>Trải nghiệm mua sắm mô hình Anime hàng đầu Việt Nam.</p>
        </div>
      </div>

      <div class="login-main">
        <div class="login-header">
          <h2>Chào mừng trở lại</h2>
          <p>Vui lòng đăng nhập để tiếp tục</p>
        </div>

        <div class="role-switcher">
          <button 
            type="button" 
            :class="['role-card', { active: role === 'buyer' }]"
            @click="role = 'buyer'"
          >
            <i class="fas fa-user"></i>
            <span>Người mua</span>
          </button>
          <button 
            type="button" 
            :class="['role-card', { active: role === 'manager' }]"
            @click="role = 'manager'"
          >
            <i class="fas fa-user-shield"></i>
            <span>Quản lý</span>
          </button>
        </div>

        <form @submit.prevent="submitLogin" class="login-form">
          <div class="input-group">
            <label>Email</label>
            <input 
              v-model="email" 
              type="email" 
              placeholder="email@example.com" 
              required 
            />
          </div>

          <div class="input-group">
            <label>Mật khẩu</label>
            <input 
              v-model="password" 
              type="password" 
              placeholder="••••••••" 
              required 
            />
          </div>

          <!-- Thông báo gợi ý đăng nhập khác khi có họ đơn số -->
          <div v-if="hasSingleSurnameSuggestion" class="suggestion-box">
            <i class="fas fa-lightbulb"></i>
            <span>
              Gợi ý: Thử đăng nhập với tên đầy đủ (họ + tên) thay vì email có họ đơn số
            </span>
          </div>

          <button type="submit" class="btn-submit">
            <span v-if="isLoading" class="loading-spinner"></span>
            <span v-else>Đăng nhập ngay</span>
          </button>
          
          <p v-if="error" class="error-text">{{ error }}</p>
          
          <!-- Hiển thị điểm khi đăng nhập thành công -->
          <div v-if="successMessage" class="success-message">
            <i class="fas fa-check-circle"></i>
            {{ successMessage }}
          </div>
        </form>

        <div class="divider">
          <span>Hoặc đăng nhập với</span>
        </div>

        <div class="social-actions">
          <a href="https://accounts.google.com/o/oauth2/auth" class="btn-social google">
            <img src="https://img.icons8.com/color/24/000000/google-logo.png" alt="Google" /> 
            <span>Google</span>
          </a>
          <a href="https://www.facebook.com/v12.0/dialog/oauth" class="btn-social facebook">
            <img src="https://img.icons8.com/fluency/24/000000/facebook-new.png" alt="Facebook" /> 
            <span>Facebook</span>
          </a>
        </div>

        <div class="login-footer">
          Chưa có tài khoản? <a href="#">Đăng ký ngay</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()
const email = ref("")
const password = ref("")
const role = ref("buyer")
const error = ref("")
const successMessage = ref("")
const isLoading = ref(false)

// Danh sách họ đơn số phổ biến trong tiếng Việt
const singleSurnames = [
  'Ngọc', 'Kim', 'Bảo', 'Minh', 'An', 'Hương', 'Lan', 'Mai', 
  'Linh', 'Thảo', 'Duyên', 'Hiền', 'Tâm', 'Phúc', 'Ân'
]

// Kiểm tra email có họ đơn số không
const hasSingleSurnameSuggestion = computed(() => {
  if (!email.value) return false
  
  const emailLower = email.value.toLowerCase()
  return singleSurnames.some(surname => 
    emailLower.includes(surname.toLowerCase())
  )
})

const submitLogin = async () => {
  error.value = ""
  successMessage.value = ""
  isLoading.value = true

  try {
    // Logic kiểm tra tài khoản quản lý
    if (role.value === "manager") {
      if (email.value !== "ngocmt363@gmail.com" || password.value !== "10112005") {
        error.value = "Tài khoản quản lý không hợp lệ!"
        return
      }
    }

    // Giả lập API call (thay bằng API thật)
    await new Promise(resolve => setTimeout(resolve, 1000))

    // Lưu thông tin đăng nhập
    const userData = {
      isAuthenticated: true,
      role: role.value,
      email: email.value,
      points: getRandomPoints(), // Công điểm ngẫu nhiên
      loginTime: new Date().toISOString()
    }
    
    localStorage.setItem("auth", JSON.stringify(userData))
    
    // Hiển thị thông báo thành công với điểm
    successMessage.value = `Đăng nhập thành công! Bạn nhận được ${userData.points} điểm`
    
    // Chuyển hướng sau 1.5s
    setTimeout(() => {
      if (role.value === "manager") {
        router.push("/admin/customers")
      } else {
        router.push("/")
      }
    }, 1500)

  } catch (err) {
    error.value = "Có lỗi xảy ra, vui lòng thử lại!"
  } finally {
    isLoading.value = false
  }
}

// Hàm công điểm ngẫu nhiên (có thể thay bằng logic thật)
const getRandomPoints = () => {
  return Math.floor(Math.random() * 50) + 10 // 10-60 điểm
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

.login-wrapper {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f4f7fe;
  padding: 20px;
}

.login-container {
  display: flex;
  width: 1000px;
  max-width: 100%;
  background: white;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,0.08);
}

.login-sidebar {
  flex: 1;
  background: url(https://images.unsplash.com/photo-1739371308017-ba5a130cefb8?q=80&w=736&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D) center/cover no-repeat;
  background-color: rgba(15, 21, 36, 0.85);
  background-blend-mode: overlay;
  display: flex;
  align-items: center;
  padding: 40px;
  color: white;
}

.login-main {
  width: 450px;
  padding: 50px;
}

.login-header h2 {
  font-size: 24px;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 8px;
}

.login-header p {
  color: #718096;
  margin-bottom: 32px;
}

.role-switcher {
  display: flex;
  gap: 12px;
  margin-bottom: 24px;
}

.role-card {
  flex: 1;
  padding: 12px;
  border: 2px solid #edf2f7;
  border-radius: 12px;
  background: white;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  transition: all 0.2s;
}

.role-card i {
  font-size: 18px;
  color: #a0aec0;
}

.role-card.active {
  border-color: #667eea;
  background: #f0f5ff;
}

.role-card.active i, .role-card.active span {
  color: #667eea;
  font-weight: 600;
}

.input-group {
  margin-bottom: 20px;
}

.input-group label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 8px;
  color: #4a5568;
}

.input-group input {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  outline: none;
  transition: 0.2s;
}

.input-group input:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

/* Gợi ý họ đơn số */
.suggestion-box {
  background: linear-gradient(135deg, #fff3cd, #ffeaa7);
  border: 1px solid #ffeaa7;
  border-radius: 8px;
  padding: 12px;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: #856404;
}

.suggestion-box i {
  color: #f39c12;
}

.btn-submit {
  width: 100%;
  padding: 14px;
  background: #1a202c;
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  margin-top: 10px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.loading-spinner {
  width: 20px;
  height: 20px;
  border: 2px solid transparent;
  border-top: 2px solid currentColor;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Thông báo thành công với điểm */
.success-message {
  background: linear-gradient(135deg, #d4edda, #c3e6cb);
  border: 1px solid #c3e6cb;
  border-radius: 8px;
  padding: 12px;
  margin-top: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: #155724;
  animation: slideIn 0.3s ease-out;
}

.success-message i {
  color: #28a745;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.divider {
  text-align: center;
  margin: 24px 0;
  position: relative;
}

.divider::before {
  content: "";
  position: absolute;
  top: 50%; left: 0; right: 0;
  height: 1px; background: #edf2f7;
}

.divider span {
  background: white;
  padding: 0 12px;
  position: relative;
  font-size: 13px;
  color: #a0aec0;
}

.social-actions {
  display: flex;
  gap: 12px;
}

.btn-social {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  background: white;
  cursor: pointer;
  font-weight: 500;
  transition: 0.2s;
  text-decoration: none;
  color: #1a202c;
}

.btn-social:hover {
  background: #f7fafc;
  border-color: #cbd5e0;
}

.login-footer {
  margin-top: 32px;
  text-align: center;
  font-size: 14px;
  color: #718096;
}

.login-footer a {
  color: #667eea;
  text-decoration: none;
  font-weight: 600;
}

.error-text {
  color: #e53e3e;
  font-size: 13px;
  margin-top: 10px;
  text-align: center;
}

@media (max-width: 850px) {
  .login-sidebar { display: none; }
  .login-container { width: 450px; }
}
</style>