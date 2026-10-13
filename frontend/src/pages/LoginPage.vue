<template>
  <q-page class="login-page">
    <div class="login-wrapper">
      <!-- LEFT: TOURISM HERO -->
      <section class="hero-section">
        <div class="hero-overlay"></div>

        <div class="hero-content">
          <div class="brand">
            <div class="brand-icon">
              <q-icon name="travel_explore" size="30px" />
            </div>

            <div>
              <div class="brand-name">TAGUM</div>
              <div class="brand-subtitle">TOURISM GUIDE</div>
            </div>
          </div>

          <div class="hero-text">
            <div class="eyebrow">
              <span class="eyebrow-line"></span>
              EXPLORE. EXPERIENCE. ENJOY.
            </div>

            <h1>
              Your next<br />
              <span>adventure</span><br />
              starts here.
            </h1>

            <p>
              Discover the culture, destinations, local treasures,
              and unforgettable experiences of Tagum City.
            </p>

            <div class="hero-location">
              <q-icon name="location_on" size="20px" />
              <span>Tagum City, Davao del Norte, Philippines</span>
            </div>
          </div>

          <div class="hero-footer">
            <span class="footer-dot"></span>
            YOUR CITY, YOUR STORY, YOUR ADVENTURE
          </div>
        </div>
      </section>

      <!-- RIGHT: LOGIN FORM -->
      <section class="form-section">
        <div class="mobile-brand">
          <q-icon name="travel_explore" size="28px" />
          <span>TAGUM <b>TOURISM GUIDE</b></span>
        </div>

        <div class="form-content">
          <div class="welcome-label">WELCOME BACK</div>

          <h2>Sign in to explore</h2>

          <p class="form-description">
            Access your account and start planning your next
            Tagum City experience.
          </p>

          <q-form @submit.prevent="login" class="login-form">
            <div class="field-label">Email address</div>

            <q-input
              v-model="email"
              type="email"
              placeholder="you@example.com"
              outlined
              rounded
              autocomplete="email"
              class="custom-input"
              lazy-rules
              :rules="[
                val => !!val || 'Please enter your email address',
                val => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) ||
                  'Please enter a valid email address'
              ]"
            >
              <template #prepend>
                <q-icon name="mail_outline" />
              </template>
            </q-input>

            <div class="password-label-row">
              <div class="field-label">Password</div>

              <a
                href="#"
                class="forgot-link"
                @click.prevent="forgotPassword"
              >
                Forgot password?
              </a>
            </div>

            <q-input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Enter your password"
              outlined
              rounded
              autocomplete="current-password"
              class="custom-input"
              lazy-rules
              :rules="[
                val => !!val || 'Please enter your password'
              ]"
            >
              <template #prepend>
                <q-icon name="lock_outline" />
              </template>

              <template #append>
                <q-icon
                  :name="showPassword ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="showPassword = !showPassword"
                />
              </template>
            </q-input>

            <q-checkbox
              v-model="rememberMe"
              label="Remember me"
              color="primary"
              class="remember-checkbox"
            />

            <q-btn
              type="submit"
              label="Sign In"
              icon-right="arrow_forward"
              no-caps
              unelevated
              rounded
              class="sign-in-btn"
            />

            <div v-if="message" class="status-message">
              <q-icon name="info_outline" size="18px" />
              {{ message }}
            </div>
          </q-form>

          <div class="divider">
            <span></span>
            <p>YOUR JOURNEY STARTS HERE</p>
            <span></span>
          </div>

          <div class="register-text">
            New to Tagum Tourism Guide?
            <a href="#" @click.prevent="register">
              Create an account
            </a>
          </div>

          <div class="security-note">
            <q-icon name="verified_user" size="17px" />
            <span>Your account information should be kept secure.</span>
          </div>
        </div>

        <footer class="page-footer">
          <span>© {{ new Date().getFullYear() }} Tagum Tourism Guide</span>
          <span class="footer-separator">•</span>
          <span>Discover more. Travel better.</span>
        </footer>
      </section>
    </div>
  </q-page>
</template>

<script setup>
import { ref } from 'vue'

const email = ref('')
const password = ref('')
const showPassword = ref(false)
const rememberMe = ref(false)
const message = ref('')

function login() {
  message.value =
    'Login form validated. Connect this form to your Laravel authentication API to sign in.'
}

function forgotPassword() {
  message.value =
    'Password recovery will be available once it is connected to the backend.'
}

function register() {
  message.value =
    'The registration page has not been connected yet.'
}
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  background: #f7f8f5;
  color: #202b25;
  font-family: Inter, "Segoe UI", Arial, sans-serif;
}

.login-wrapper {
  display: grid;
  grid-template-columns: 1.05fr 0.95fr;
  min-height: 100vh;
}

/* TOURISM HERO */

.hero-section {
  position: relative;
  display: flex;
  min-height: 100vh;
  overflow: hidden;
  color: white;
  background-color: #173f32;
  background-image:
    linear-gradient(
      120deg,
      rgba(10, 43, 33, 0.92) 0%,
      rgba(15, 58, 43, 0.72) 48%,
      rgba(14, 42, 35, 0.40) 100%
    ),
    url("https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1800&q=85");
  background-position: center;
  background-size: cover;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  pointer-events: none;
  background: linear-gradient(
    0deg,
    rgba(7, 30, 24, 0.55),
    transparent 50%
  );
}

.hero-content {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  width: 100%;
  padding: 46px 8%;
}

.brand {
  display: flex;
  align-items: center;
  gap: 13px;
}

.brand-icon {
  display: grid;
  width: 53px;
  height: 53px;
  place-items: center;
  color: #173f32;
  background: #d7bb78;
  border-radius: 16px;
}

.brand-name {
  font-size: 22px;
  font-weight: 850;
  letter-spacing: 3px;
}

.brand-subtitle {
  margin-top: 3px;
  color: #e4d5a8;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 3px;
}

.hero-text {
  max-width: 560px;
  margin: auto 0;
  padding: 65px 0;
}

.eyebrow {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #e4cf91;
  font-size: 11px;
  font-weight: 750;
  letter-spacing: 2px;
}

.eyebrow-line {
  width: 34px;
  height: 2px;
  background: #d7bb78;
}

.hero-text h1 {
  margin: 28px 0 22px;
  font-size: clamp(42px, 5vw, 68px);
  font-weight: 800;
  line-height: 1.07;
  letter-spacing: -2px;
}

.hero-text h1 span {
  color: #e3c77f;
}

.hero-text p {
  max-width: 425px;
  color: rgba(255, 255, 255, 0.83);
  font-size: 15px;
  line-height: 1.9;
}

.hero-location {
  display: flex;
  align-items: center;
  gap: 9px;
  margin-top: 29px;
  color: #f1e5c6;
  font-size: 12px;
}

.hero-footer {
  display: flex;
  align-items: center;
  gap: 10px;
  color: rgba(255, 255, 255, 0.73);
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 1.8px;
}

.footer-dot {
  width: 7px;
  height: 7px;
  background: #d7bb78;
  border-radius: 50%;
}

/* LOGIN PANEL */

.form-section {
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-width: 0;
  padding: 50px clamp(28px, 6vw, 92px) 24px;
  background: #fbfcf9;
}

.form-content {
  width: 100%;
  max-width: 420px;
  margin: auto;
}

.mobile-brand {
  display: none;
}

.welcome-label {
  color: #6b886f;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 2.5px;
}

.form-content h2 {
  margin: 13px 0 10px;
  color: #203a2d;
  font-size: clamp(27px, 3vw, 35px);
  font-weight: 800;
  letter-spacing: -1px;
}

.form-description {
  margin: 0 0 33px;
  color: #818a82;
  font-size: 13px;
  line-height: 1.8;
}

.field-label {
  margin-bottom: 9px;
  color: #35483b;
  font-size: 12px;
  font-weight: 750;
}

.custom-input {
  margin-bottom: 21px;
}

.custom-input :deep(.q-field__control) {
  min-height: 54px;
  background: white;
  border-radius: 12px;
}

.custom-input :deep(.q-field__control:before) {
  border-color: #e0e6dd;
}

.custom-input :deep(.q-field__control:hover:before) {
  border-color: #8aa58d;
}

.custom-input :deep(.q-field__control:after) {
  border-color: #37694d;
}

.custom-input :deep(.q-field__prepend),
.custom-input :deep(.q-field__append) {
  color: #849587;
}

.custom-input :deep(input) {
  color: #27392d;
  font-size: 13px;
}

.custom-input :deep(input::placeholder) {
  color: #a5ada5;
  opacity: 1;
}

.password-label-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}

.forgot-link {
  margin-bottom: 9px;
  color: #427451;
  font-size: 11px;
  font-weight: 700;
  text-decoration: none;
}

.forgot-link:hover,
.register-text a:hover {
  text-decoration: underline;
}

.remember-checkbox {
  margin: -5px 0 19px -8px;
  color: #68776b;
  font-size: 12px;
}

.sign-in-btn {
  width: 100%;
  min-height: 53px;
  color: white;
  background: #28583f;
  font-size: 13px;
  font-weight: 750;
  letter-spacing: 0.3px;
  box-shadow: 0 8px 18px rgba(40, 88, 63, 0.15);
  transition: background 0.2s, transform 0.2s;
}

.sign-in-btn:hover {
  background: #1e4732;
  transform: translateY(-1px);
}

.status-message {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin-top: 15px;
  padding: 12px;
  color: #365e44;
  background: #edf4eb;
  border-radius: 10px;
  font-size: 12px;
  line-height: 1.6;
}

.status-message .q-icon {
  flex-shrink: 0;
  margin-top: 1px;
}

.divider {
  display: flex;
  align-items: center;
  gap: 13px;
  margin: 30px 0 24px;
}

.divider span {
  flex: 1;
  height: 1px;
  background: #e8ece5;
}

.divider p {
  margin: 0;
  color: #a1a99f;
  font-size: 9px;
  font-weight: 750;
  letter-spacing: 1.4px;
  white-space: nowrap;
}

.register-text {
  color: #858d85;
  font-size: 12px;
  text-align: center;
}

.register-text a {
  color: #356b49;
  font-weight: 800;
  text-decoration: none;
}

.security-note {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  margin-top: 34px;
  color: #9aa39a;
  font-size: 10px;
}

.page-footer {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 9px;
  padding-top: 35px;
  color: #a0a79f;
  font-size: 10px;
}

.footer-separator {
  color: #c4cbbf;
}

/* RESPONSIVE */

@media (max-width: 900px) {
  .login-wrapper {
    grid-template-columns: 0.9fr 1.1fr;
  }

  .hero-content {
    padding: 35px 7%;
  }

  .form-section {
    padding-right: 30px;
    padding-left: 30px;
  }

  .brand-name {
    font-size: 18px;
  }
}

@media (max-width: 680px) {
  .login-wrapper {
    display: block;
    min-height: 100vh;
  }

  .hero-section {
    display: none;
  }

  .form-section {
    min-height: 100vh;
    padding: 28px 23px 20px;
  }

  .mobile-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 45px;
    color: #28583f;
    font-size: 16px;
    font-weight: 850;
    letter-spacing: 1px;
  }

  .mobile-brand b {
    display: block;
    margin-top: 3px;
    color: #8a9a87;
    font-size: 9px;
    letter-spacing: 2px;
  }

  .form-content {
    max-width: 430px;
  }

  .form-content h2 {
    font-size: 30px;
  }

  .page-footer {
    padding-top: 35px;
    font-size: 9px;
  }
}

@media (prefers-reduced-motion: reduce) {
  .sign-in-btn {
    transition: none;
  }
}
</style>
