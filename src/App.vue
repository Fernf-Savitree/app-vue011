<template>
<div class="container">
  <!-- memu
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/about">About</router-link> |
    <router-link to="/Contact">Contact</router-link>
  </nav>
   -->

 <nav class="navbar navbar-expand-lg bg-body-tertiary">

  <div class="container-fluid">

    <a class="navbar-brand" href="/">SAVI Shop</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

      <span class="navbar-toggler-icon"></span>

    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">

          <a class="nav-link active" aria-current="page" href="/">Home</a>

        </li>

        <li class="nav-item" v-if="isLoggedIn">

          <a class="nav-link" href="/Customer">Customer</a>

        </li>
        <li class="nav-item" v-if="isLoggedIn">

          <a class="nav-link" href="/Customer_crud">Customer_crud</a>

        </li>
                <li class="nav-item dropdown">

          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            Product

          </a>

          <ul class="dropdown-menu">

            <li v-if="isLoggedIn"><a class="dropdown-item" href="Product">Product</a></li>

            <li v-if="isLoggedIn"><a class="dropdown-item" href="Product_api">Product_api</a></li>

            <li v-if="isLoggedIn"><a class="dropdown-item" href="Product_crud">Product_crud</a></li>

            <li><a class="dropdown-item" href="Show_product">Show_product</a></li>

            <li v-if="isLoggedIn"><hr class="dropdown-divider"></li>

            <li v-if="isLoggedIn"><a class="dropdown-item" href="#">Something else here</a></li>

          </ul>

        </li>

         <li class="nav-item">

          <a class="nav-link" href="/Contact">Contact</a>

        </li>

         <li class="nav-item" v-if="isLoggedIn">

          <a class="nav-link" href="/type">Type</a>

        </li>
        <li class="nav-item" v-if="isLoggedIn">

          <a class="nav-link" href="/Type_crud">Type_crud</a>

        </li>


        <li class="nav-item dropdown" v-if="isLoggedIn">

          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            Employee

          </a>

          <ul class="dropdown-menu">

            <li v-if="isLoggedIn"><a class="dropdown-item" href="employee">Employee</a></li>

            <li v-if="isLoggedIn"><a class="dropdown-item" href="Employee_crud">Employee_crud</a></li>

            <li v-if="isLoggedIn"><a class="dropdown-item" href="Employee_crud_image">Employee_crud_image</a></li>

            <li v-if="isLoggedIn"><hr class="dropdown-divider"></li>

            <li v-if="isLoggedIn"><a class="dropdown-item" href="#">Something else here</a></li>

          </ul>

        </li>

    



               <li class="nav-item dropdown" v-if="isLoggedIn">

          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            Student

          </a>

          <ul class="dropdown-menu">

            <li v-if="isLoggedIn"><a class="dropdown-item" href="Student">Student</a></li>

            <li v-if="isLoggedIn"><a class="dropdown-item" href="Student_crud">Student_crud</a></li>

            <li v-if="isLoggedIn"><hr class="dropdown-divider"></li>

            <li v-if="isLoggedIn"><a class="dropdown-item" href="#">Something else here</a></li>

          </ul>

        </li>

        <li class="nav-item" v-if="isLoggedIn">

          <a class="nav-link disabled" aria-disabled="true">Disabled</a>

        </li>

      </ul>

     <!-- ✅ ส่วนแสดงสถานะ Login -->
        <div class="d-flex align-items-center">

          <!-- แสดงชื่อผู้ใช้ -->
          <span v-if="isLoggedIn" class="me-3">
            👤 <span class="badge bg-success">{{ userName }}</span>
          </span>

          <!-- ปุ่ม Login (ถ้ายังไม่ Login) -->
          <router-link
            v-if="!isLoggedIn"
            to="/login"
            class="btn btn-primary"
          >
            Login
          </router-link>

          <!-- ปุ่ม Logout (ถ้า Login แล้ว) -->
          <button
            v-if="isLoggedIn"
            @click="logout"
            class="btn btn-danger"
          >
            Logout
          </button>

        </div>
        
    </div>
  </div>
</nav>

    <!-- ✅ แสดงหน้าที่เลือก -->
  <div class="container mt-3">
    <router-view/>
  </div>
</div>
</template>



<script>
export default {
  data() {
    return {
      // ✅ ตัวแปรเก็บสถานะ Login
      isLoggedIn: false,

      // ✅ ตัวแปรเก็บชื่อผู้ใช้
      userName: ""
    }
  },

  // ✅ ทำงานทันทีเมื่อโหลด Component
  mounted() {
    this.checkLogin()
  },

  methods: {

    // ✅ ตรวจสอบสถานะ Login จาก localStorage
    checkLogin() {

      // ถ้ามี adminLogin → ถือว่า Login แล้ว
      this.isLoggedIn = !!localStorage.getItem("adminLogin")

      if (this.isLoggedIn) {

        // ดึงข้อมูล user
        const user = JSON.parse(localStorage.getItem("user"))

        // แสดงชื่อ ถ้าไม่มีใช้ "Admin"
        this.userName = user?.name || "Admin"
      }
    },

    // ✅ Logout
    logout() {

      // ลบข้อมูล Login
      localStorage.removeItem("adminLogin")
      localStorage.removeItem("user")

      // รีเซ็ตค่า
      this.isLoggedIn = false
      this.userName = ""

      // ไปหน้า Login
      this.$router.push("/login")
    }
  },

  // ✅ ถ้าเปลี่ยนหน้า → เช็ค Login ใหม่
  watch: {
    '$route'() {
      this.checkLogin()
    }
  }
}
</script>