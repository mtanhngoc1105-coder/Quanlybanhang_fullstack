<template>
  <div class="login-container">
    <div class="form-section">
      <div class="login-glass">
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
              autocomplete="email"
              placeholder="email@example.com" 
              required 
            />
            <i class="fas fa-envelope input-icon"></i>
          </div>

          <div class="input-group">
            <label>Mật khẩu</label>
            <input 
              v-model="password" 
              type="password" 
              autocomplete="current-password"
              placeholder="••••••••" 
              required 
            />
            <i class="fas fa-eye-slash input-icon"></i>
          </div>

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
      </div>
    </div>

    <div class="character-section">
      <Character3D />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from "vue"
import { useRouter } from "vue-router"
import axiosInstance from "../api/axiosInstance"
import Character3D from "../components/Character3D.vue"

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
    // Gọi backend API để đăng nhập
    const response = await axiosInstance.post('/api/login', {
      email: email.value,
      password: password.value
    })

    const { token, user } = response.data

    // Lưu JWT token
    localStorage.setItem("auth_token", token)
    
    // Lưu thông tin user và auth status
    const userData = {
      isAuthenticated: true,
      role: user.role,
      email: user.email,
      id: user.id,
      name: user.name,
      points: user.points || 0,
      loginTime: new Date().toISOString()
    }
    
    localStorage.setItem("auth", JSON.stringify(userData))
    
    // Hiển thị thông báo thành công
    successMessage.value = `Đăng nhập thành công! Chào ${user.name}`
    
    // Chuyển hướng sau 1.5s
    setTimeout(() => {
      if (user.role === "manager") {
        router.push("/admin/customers")
      } else {
        router.push("/")
      }
    }, 1500)

  } catch (err) {
    if (err.response?.status === 401) {
      error.value = err.response?.data?.message || "Email hoặc mật khẩu không đúng!"
    } else {
      error.value = err.response?.data?.message || "Có lỗi xảy ra, vui lòng thử lại!"
    }
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

.login-container {
  /* Chiếm trọn toàn bộ màn hình */
  width: 100vw;
  height: 100vh;

  /* Đường dẫn đến ảnh nền */
  background-image: url('/images/login.jpg');

  /* Căn chỉnh ảnh nền chuẩn */
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;

  /* Layout flexbox */
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 8% 0 15%; /* Tăng lề trái và phải để xịch vào giữa */
  overflow: hidden;
  box-sizing: border-box;
}

.form-section {
  width: 450px;
  z-index: 2;
}

.character-section {
  position: relative;
  height: 100vh;
  width: 50%;
  z-index: 1;
}

/* Hiệu ứng Glassmorphism cho form */
.login-glass {
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(25px);
  -webkit-backdrop-filter: blur(25px);
  border: 1px solid rgba(255, 255, 255, 0.4);
  border-radius: 24px;
  padding: 40px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.login-header h2 {
  font-size: 28px;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 8px;
}

.login-header p {
  color: #4a5568;
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
  border: 1px solid rgba(255, 255, 255, 0.5);
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.4);
  cursor: pointer;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  transition: all 0.2s;
  color: #4a5568;
}

.role-card.active {
  background: rgba(255, 255, 255, 0.9);
  border-color: #ffffff;
  color: #667eea;
}

.role-card.active i, .role-card.active span {
  color: #667eea;
  font-weight: 600;
}

.input-group {
  margin-bottom: 20px;
  position: relative;
}

.input-group label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 8px;
  color: #1a202c;
}

.input-group input {
  width: 100%;
  padding: 14px 16px;
  background: rgba(255, 255, 255, 0.5);
  border: 1px solid rgba(255, 255, 255, 0.6);
  border-radius: 12px;
  outline: none;
  transition: 0.2s;
  color: #1a202c;
  font-size: 15px;
  box-sizing: border-box;
}

.input-group input::placeholder {
  color: #718096;
}

.input-group input:focus {
  background: rgba(255, 255, 255, 0.8);
  border-color: #ffffff;
  box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3);
}

.input-icon {
  position: absolute;
  right: 16px;
  top: 42px;
  color: #a0aec0;
}

.btn-submit {
  width: 100%;
  padding: 16px;
  background: #1a202c;
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 600;
  font-size: 16px;
  cursor: pointer;
  margin-top: 10px;
  transition: 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-submit:hover {
  background: #2d3748;
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

.suggestion-box {
  background: rgba(255, 243, 205, 0.8);
  border: 1px solid rgba(255, 234, 167, 0.8);
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

.success-message {
  background: rgba(212, 237, 218, 0.8);
  border: 1px solid rgba(195, 230, 203, 0.8);
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
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
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
  height: 1px; 
  background: rgba(0, 0, 0, 0.1);
}

.divider span {
  background: rgba(255, 255, 255, 0.3);
  backdrop-filter: blur(5px);
  padding: 4px 12px;
  border-radius: 12px;
  position: relative;
  font-size: 13px;
  color: #4a5568;
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
  padding: 12px;
  border: 1px solid rgba(255, 255, 255, 0.6);
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.4);
  cursor: pointer;
  font-weight: 500;
  transition: 0.2s;
  text-decoration: none;
  color: #1a202c;
}

.btn-social:hover {
  background: rgba(255, 255, 255, 0.7);
}

.error-text {
  color: #e53e3e;
  font-size: 13px;
  margin-top: 10px;
  text-align: center;
}

@media (max-width: 850px) {
  .login-container { 
    flex-direction: column;
    justify-content: center;
  }
  .character-section { display: none; }
  .form-section { width: 100%; max-width: 450px; }
}
</style>