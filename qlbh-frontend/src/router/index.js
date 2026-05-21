import { createRouter, createWebHistory } from "vue-router"


// layouts
import AdminLayout from "../layouts/AdminLayout.vue"
import MainLayout from "../layouts/MainLayout.vue"

// Public pages
import Home from "../pages/Home.vue"
import ProductsPublic from "../pages/public/ProductsPublic.vue"
import ProductDetailPublic from "../pages/public/ProductDetail.vue"
import Cart from "../pages/Cart.vue"
import Checkout from "../pages/Checkout.vue"
import OrderSuccess from "../pages/OrderSuccess.vue"
import Contact from "../pages/Contact.vue"
import Login from "../pages/Login.vue"
import NotFound from "../pages/NotFound.vue"

// New pages for different sections
import Guide from "../pages/Guide.vue"
import News from "../pages/News.vue"
import Recruitment from "../pages/Recruitment.vue"
import About from "../pages/About.vue"
import Promotions from "../pages/Promotions.vue"

// ===== ADMIN PAGES =====

// customers
import CustomerList from "../pages/customers/CustomerList.vue"
import CustomerCreate from "../pages/customers/CustomerCreate.vue"
import CustomerDetail from "../pages/customers/CustomerDetail.vue"
import CustomerEdit from "../pages/customers/CustomerEdit.vue"

// drivers
import DriverList from "../pages/drivers/DriverList.vue"
import DriverCreate from "../pages/drivers/DriverCreate.vue"
import DriverDetail from "../pages/drivers/DriverDetail.vue"
import DriverEdit from "../pages/drivers/DriverEdit.vue"

// driver orders
import DriverOrderList from "../pages/driver-orders/DriverOrderList.vue"
import DriverOrderCreate from "../pages/driver-orders/DriverOrderCreate.vue"
import DriverOrderDetail from "../pages/driver-orders/DriverOrderDetail.vue"
import DriverOrderEdit from "../pages/driver-orders/DriverOrderEdit.vue"

// orders
import OrderList from "../pages/orders/OrderList.vue"
import OrderCreate from "../pages/orders/OrderCreate.vue"
import OrderDetail from "../pages/orders/OrderDetail.vue"
import OrderEdit from "../pages/orders/OrderEdit.vue"

// order items
import OrderItemList from "../pages/orderItems/OrderItemList.vue"
import OrderItemCreate from "../pages/orderItems/OrderItemCreate.vue"
import OrderItemDetail from "../pages/orderItems/OrderItemDetail.vue"
import OrderItemEdit from "../pages/orderItems/OrderItemEdit.vue"

// post offices
import PostOfficeList from "../pages/postoffices/PostOfficeList.vue"
import PostOfficeCreate from "../pages/postoffices/PostOfficeCreate.vue"
import PostOfficeDetail from "../pages/postoffices/PostOfficeDetail.vue"
import PostOfficeEdit from "../pages/postoffices/PostOfficeEdit.vue"

// products
import ProductList from "../pages/products/ProductList.vue"
import ProductCreate from "../pages/products/ProductCreate.vue"
import ProductEdit from "../pages/products/ProductEdit.vue"
import ProductDetail from "../pages/products/ProductDetail.vue"

// reviews
import ReviewList from "../pages/reviews/ReviewList.vue"
import ReviewCreate from "../pages/reviews/ReviewCreate.vue"
import ReviewEdit from "../pages/reviews/ReviewEdit.vue"
import ReviewDetail from "../pages/reviews/ReviewDetail.vue"

// sellers
import SellerList from "../pages/sellers/SellerList.vue"
import SellerCreate from "../pages/sellers/SellerCreate.vue"
import SellerEdit from "../pages/sellers/SellerEdit.vue"
import SellerDetail from "../pages/sellers/SellerDetail.vue"

// vouchers
import VoucherList from "../pages/vouchers/VoucherList.vue"
import VoucherCreate from "../pages/vouchers/VoucherCreate.vue"
import VoucherEdit from "../pages/vouchers/VoucherEdit.vue"
import VoucherDetail from "../pages/vouchers/VoucherDetail.vue"

// categories
import CategoryList from "../pages/categories/CategoryList.vue"
import CategoryCreate from "../pages/categories/CategoryCreate.vue"
import CategoryEdit from "../pages/categories/CategoryEdit.vue"
import CategoryDetail from "../pages/categories/CategoryDetail.vue"


// ================= ROUTES =================

const routes = [
  // PUBLIC ROUTES
  {
  path: "/",
  component: MainLayout,
  children: [
    { path: "", component: Home },
    { path: "shop", component: ProductsPublic },
    { path: "products/:id", component: ProductDetailPublic },
    { path: "cart", component: Cart },
    { path: "checkout", component: Checkout },
    { path: "order-success/:id", component: OrderSuccess },
    { path: "category/:slug", component: ProductsPublic }, // FIXED
    { path: "contact", component: Contact },
    { path: "about", component: About },
    { path: "promotions", component: Promotions }, // OK
    { path: "guide", component: Guide },
    { path: "news", component: News },
    { path: "recruitment", component: Recruitment },
  ]
},

  // ADMIN ROUTES
  {
    path: "/admin",
    component: AdminLayout,
    children: [
      { path: "", redirect: "/admin/customers" },

      // customers
      { path: "customers", component: CustomerList, meta: { title: "Danh sách khách hàng" } },
      { path: "customers/create", component: CustomerCreate, meta: { title: "Thêm khách hàng" } },
      { path: "customers/:id", component: CustomerDetail, meta: { title: "Chi tiết khách hàng" } },
      { path: "customers/edit/:id", component: CustomerEdit, meta: { title: "Sửa khách hàng" } },

      // drivers
      { path: "drivers", component: DriverList, meta: { title: "Danh sách tài xế" } },
      { path: "drivers/create", component: DriverCreate, meta: { title: "Thêm tài xế" } },
      { path: "drivers/:id", component: DriverDetail, meta: { title: "Chi tiết tài xế" } },
      { path: "drivers/edit/:id", component: DriverEdit, meta: { title: "Sửa tài xế" } },

      // driver orders
      { path: "driver-orders", component: DriverOrderList, meta: { title: "Danh sách đơn tài xế" } },
      { path: "driver-orders/create", component: DriverOrderCreate, meta: { title: "Thêm đơn tài xế" } },
      { path: "driver-orders/:id", component: DriverOrderDetail, meta: { title: "Chi tiết đơn tài xế" } },
      { path: "driver-orders/edit/:id", component: DriverOrderEdit, meta: { title: "Sửa đơn tài xế" } },

      // orders
      { path: "orders", component: OrderList, meta: { title: "Danh sách đơn hàng" } },
      { path: "orders/create", component: OrderCreate, meta: { title: "Thêm đơn hàng" } },
      { path: "orders/:id", component: OrderDetail, meta: { title: "Chi tiết đơn hàng" } },
      { path: "orders/edit/:id", component: OrderEdit, meta: { title: "Sửa đơn hàng" } },

      // order items
      { path: "order-items", component: OrderItemList, meta: { title: "Danh sách chi tiết đơn" } },
      { path: "order-items/create", component: OrderItemCreate, meta: { title: "Thêm chi tiết đơn" } },
      { path: "order-items/:id", component: OrderItemDetail, meta: { title: "Chi tiết chi tiết đơn" } },
      { path: "order-items/edit/:id", component: OrderItemEdit, meta: { title: "Sửa chi tiết đơn" } },

      // post offices
      { path: "postoffices", component: PostOfficeList, meta: { title: "Danh sách bưu cục" } },
      { path: "postoffices/create", component: PostOfficeCreate, meta: { title: "Thêm bưu cục" } },
      { path: "postoffices/:id", component: PostOfficeDetail, meta: { title: "Chi tiết bưu cục" } },
      { path: "postoffices/edit/:id", component: PostOfficeEdit, meta: { title: "Sửa bưu cục" } },

      // products
      { path: "products", component: ProductList, meta: { title: "Danh sách sản phẩm" } },
      { path: "products/create", component: ProductCreate, meta: { title: "Thêm sản phẩm" } },
      { path: "products/edit/:id", component: ProductEdit, meta: { title: "Sửa sản phẩm" } },
      { path: "products/:id", component: ProductDetail, meta: { title: "Chi tiết sản phẩm" } },

      // reviews
      { path: "reviews", component: ReviewList, meta: { title: "Danh sách đánh giá" } },
      { path: "reviews/create", component: ReviewCreate, meta: { title: "Thêm đánh giá" } },
      { path: "reviews/edit/:id", component: ReviewEdit, meta: { title: "Sửa đánh giá" } },
      { path: "reviews/:id", component: ReviewDetail, meta: { title: "Chi tiết đánh giá" } },

      // sellers
      { path: "sellers", component: SellerList, meta: { title: "Danh sách người bán" } },
      { path: "sellers/create", component: SellerCreate, meta: { title: "Thêm người bán" } },
      { path: "sellers/edit/:id", component: SellerEdit, meta: { title: "Sửa người bán" } },
      { path: "sellers/:id", component: SellerDetail, meta: { title: "Chi tiết người bán" } },

      // vouchers
      { path: "vouchers", component: VoucherList, meta: { title: "Danh sách voucher" } },
      { path: "vouchers/create", component: VoucherCreate, meta: { title: "Thêm voucher" } },
      { path: "vouchers/edit/:id", component: VoucherEdit, meta: { title: "Sửa voucher" } },
      { path: "vouchers/:id", component: VoucherDetail, meta: { title: "Chi tiết voucher" } },

      // categories
      { path: "categories", component: CategoryList, meta: { title: "Danh sách danh mục" } },
      { path: "categories/create", component: CategoryCreate, meta: { title: "Thêm danh mục" } },
      { path: "categories/edit/:id", component: CategoryEdit, meta: { title: "Sửa danh mục" } },
      { path: "categories/:id", component: CategoryDetail, meta: { title: "Chi tiết danh mục" } },

  
    ]
  },

  // LOGIN Route
  { path: "/login", component: Login, meta: { title: "Đăng nhập" } },

  // 404 Page
  { path: "/:pathMatch(.*)*", component: NotFound }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const auth = JSON.parse(localStorage.getItem("auth") || "null")

  if (to.path.startsWith("/admin") && (!auth || !auth.isAuthenticated || auth.role !== "manager")) {
    next("/login")
  } else {
    next()
  }
})

export default router