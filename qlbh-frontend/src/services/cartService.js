// src/services/cartService.js

const CART_KEY = "cart"
const CART_UPDATED_EVENT = "cart-updated"

const dispatchCartUpdate = () => {
  window.dispatchEvent(new Event(CART_UPDATED_EVENT))
}

// Lấy giỏ hàng
export const getCart = () => {
  const cart = localStorage.getItem(CART_KEY)
  return cart ? JSON.parse(cart) : []
}

// Lưu giỏ hàng
const saveCart = (cart) => {
  localStorage.setItem(CART_KEY, JSON.stringify(cart))
  dispatchCartUpdate()
}

const normalizeQuantity = (value) => {
  const quantity = Number(value)
  return Number.isNaN(quantity) || quantity < 1 ? 1 : Math.floor(quantity)
}

// Thêm vào giỏ
export const addToCartService = (product, quantity = 1) => {
  const cart = getCart()
  const normalizedQuantity = normalizeQuantity(quantity)
  const existing = cart.find(item => item.id === product.id)

  if (existing) {
    existing.quantity += normalizedQuantity
  } else {
    cart.push({
      id: product.id,
      name: product.product_name || product.name || "Sản phẩm",
      price: Number(product.price) || 0,
      image: product.image || "",
      quantity: normalizedQuantity,
    })
  }

  saveCart(cart)
}

// Xoá sản phẩm
export const removeFromCartService = (id) => {
  const cart = getCart().filter(item => item.id !== id)
  saveCart(cart)
}

// Tăng giảm số lượng
export const updateQuantityService = (id, quantity) => {
  const cart = getCart()
  const item = cart.find((i) => i.id === id)
  if (!item) return

  item.quantity = normalizeQuantity(quantity)
  saveCart(cart)
}

export const getCartCount = () => {
  return getCart().reduce((total, item) => total + Number(item.quantity || 0), 0)
}

export const getCartTotal = () => {
  return getCart().reduce((total, item) => {
    return total + Number(item.price || 0) * Number(item.quantity || 0)
  }, 0)
}

export const clearCartService = () => {
  saveCart([])
}

export const subscribeCartUpdates = (callback) => {
  window.addEventListener(CART_UPDATED_EVENT, callback)
  return () => window.removeEventListener(CART_UPDATED_EVENT, callback)
}
