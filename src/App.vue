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

    <a class="navbar-brand" href="/">Navbar</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

      <span class="navbar-toggler-icon"></span>

    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">

          <a class="nav-link active" aria-current="page" href="/">Home</a>

        </li>

        <li class="nav-item">

          <a class="nav-link" href="/Customer">Customer</a>

        </li>
        <li class="nav-item">

          <a class="nav-link" href="/Customer_crud">Customer_crud</a>

        </li>
         <li class="nav-item">

          <a class="nav-link" href="/Contact">Contact</a>

        </li>

         <li class="nav-item">

          <a class="nav-link" href="/type">Type</a>

        </li>
        <li class="nav-item">

          <a class="nav-link" href="/Type_crud">Type_crud</a>

        </li>

         <li class="nav-item">

          <a class="nav-link" href="/employee">Employee</a>

        </li>
        <li class="nav-item">

          <a class="nav-link" href="/Employee_crud">Employee_crud</a>

        </li>

    

        <li class="nav-item dropdown">

          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            Product

          </a>

          <ul class="dropdown-menu">

            <li><a class="dropdown-item" href="Product">Product</a></li>

            <li><a class="dropdown-item" href="Product_api">Product_api</a></li>

            <li><a class="dropdown-item" href="Show_product">Show_product</a></li>

            <li><hr class="dropdown-divider"></li>

            <li><a class="dropdown-item" href="#">Something else here</a></li>

          </ul>

        </li>

               <li class="nav-item dropdown">

          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            Student

          </a>

          <ul class="dropdown-menu">

            <li><a class="dropdown-item" href="Student">Student</a></li>

            <li><a class="dropdown-item" href="Student_crud">Student_crud</a></li>

            <li><hr class="dropdown-divider"></li>

            <li><a class="dropdown-item" href="#">Something else here</a></li>

          </ul>

        </li>

        <li class="nav-item">

          <a class="nav-link disabled" aria-disabled="true">Disabled</a>

        </li>

      </ul>

      <form class="d-flex" role="search">

        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>

        <button class="btn btn-outline-success" type="submit">Search</button>

      </form>

    </div>

  </div>

</nav>

  <router-view/>

  </div>



</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
 
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #0004fd;
}
</style>