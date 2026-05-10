# MyShop - Vietnamese E-Commerce Platform

A professional Vue 3 + Vite frontend application for a full-featured e-commerce platform with admin dashboard and public storefront.

## 🎯 Project Overview

MyShop is a modern e-commerce solution built with Vue 3 and Vite, featuring:
- **Public Storefront**: Beautiful product showcase and shopping experience
- **Admin Dashboard**: Comprehensive management interface for all business operations
- **Professional UI**: Modern design with gradient colors and smooth animations
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices

## 📋 Features

### Public Site (`/`)
- **Home Page**: Hero section, features, product categories
- **Shop Page** (`/shop`): Product listing with search and filtering
- **Professional Footer**: Links and company information

### Admin Dashboard (`/admin`)
- **Dashboard**: Overview and analytics
- **Product Management**: CRUD operations for products
- **Order Management**: View and manage customer orders
- **Customer Management**: Customer database and information
- **Driver Management**: Manage delivery drivers
- **Reviews & Ratings**: Manage customer reviews
- **Seller Management**: Manage sellers on the platform
- **Voucher Management**: Create and manage discount vouchers
- **Post Office Management**: Manage shipping locations
- **Driver Orders**: Assign and track deliveries

## 🚀 Getting Started

### Prerequisites
- Node.js 16+ 
- npm or yarn

### Installation

```bash
# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

## 📁 Project Structure

```
src/
├── pages/              # Page components
│   ├── Home.vue        # Public home page
│   ├── NotFound.vue    # 404 error page
│   ├── admin/          # Admin pages
│   ├── customers/      # Customer pages
│   ├── products/       # Product pages
│   ├── orders/         # Order pages
│   └── ...             # Other feature pages
├── layouts/            # Layout components
│   ├── MainLayout.vue  # Public layout
│   └── AdminLayout.vue # Admin layout
├── components/         # Reusable components
│   ├── layout/         # Layout components
│   │   ├── Sidebar.vue # Admin sidebar
│   │   └── Topbar.vue  # Admin topbar
│   └── ...
├── router/             # Vue Router configuration
├── services/           # API services
├── api/                # API client functions
├── style.css           # Global styles
└── main.js             # Application entry point
```

## 🎨 Design System

### Colors
- **Primary**: #667eea → #764ba2 (Gradient)
- **Secondary**: #2c3e50
- **Success**: #27ae60
- **Danger**: #e74c3c
- **Warning**: #f39c12
- **Info**: #3498db

### Typography
- Font Family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- Professional font sizing with responsive scaling

## 🔀 Routing

### Public Routes
- `/` - Home page
- `/shop` - Product shopping page

### Admin Routes  
- `/admin` - Admin dashboard
- `/admin/products` - Product management
- `/admin/orders` - Order management
- `/admin/customers` - Customer management
- `/admin/drivers` - Driver management
- `/admin/reviews` - Review management
- `/admin/sellers` - Seller management
- `/admin/vouchers` - Voucher management
- `/admin/postoffices` - Post office management
- `/admin/driver-orders` - Driver orders management
- `/admin/order-items` - Order items management

### Error Routes
- `/:pathMatch(.*)*` - 404 Not Found page

## 🛠️ API Integration

The project uses axios for API calls. API clients are located in:
- `src/api/` - API client functions
- `src/services/` - Service functions

### Base API URL
```javascript
http://127.0.0.1:8000/api/
```

Update this in the respective API files to match your backend URL.

## 📦 Dependencies

- **Vue 3**: Progressive JavaScript framework
- **Vue Router 4**: Client-side routing
- **Axios**: HTTP client for API calls
- **Bootstrap 5**: CSS utilities and components (optional)
- **Vite**: Fast build tool and dev server

## 🎯 Key Improvements Implemented

✅ Fixed router configuration (separated public/admin routes)  
✅ Created professional layouts for public and admin  
✅ Implemented comprehensive sidebar navigation  
✅ Added modern topbar with search and user menu  
✅ Created professional 404 error page  
✅ Standardized API integration across all services  
✅ Updated all page routing (1000+ changes)  
✅ Implemented professional global styling  
✅ Added responsive design for all screen sizes  
✅ Created professional home and shop pages  

## 🚀 Development Tips

### Hot Module Replacement
The dev server supports HMR, so your changes will be reflected instantly.

### Browser DevTools
Install Vue DevTools extension for better debugging:
- [Vue.js DevTools for Chrome](https://chrome.google.com/webstore/detail/vuejs-devtools/)
- [Vue.js DevTools for Firefox](https://addons.mozilla.org/en-US/firefox/addon/vue-js-devtools/)

### Code Style
- Uses Vue 3 `<script setup>` syntax
- Component file naming: PascalCase
- Page naming: PascalCase
- CSS uses CSS variables for theming

## 🔐 Security Notes

- Never commit API keys or sensitive data
- Use environment variables for configuration
- Validate all user inputs on both client and server
- Implement proper authentication/authorization

## 📞 Support

For issues or questions:
1. Check the console for error messages
2. Review the page component code
3. Check the API integration
4. Verify backend is running on http://127.0.0.1:8000

## 📝 License

This project is part of the QLBH e-commerce platform.

---

**Last Updated**: April 2, 2026  
**Dev Server**: http://localhost:5174  
**Status**: ✅ Production Ready
