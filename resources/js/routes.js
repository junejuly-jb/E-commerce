import Vue from 'vue'
import VueRouter from 'vue-router'

// import components
import Home from './components/Home.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import Admindashboard from './components/Admin/Admindashboard.vue'
import AdminProfile from './components/Admin/AdminProfile.vue'
import AdminUserList from './components/Admin/AdminUserList.vue'
import AdminStoreList from './components/Admin/AdminStoreList.vue'
import AdminStoreRequests from './components/Admin/AdminStoreRequests.vue'
import Sellerdashboard from './components/Seller/Sellerdashboard.vue'
import SellerInventory from './components/Seller/SellerInventory.vue'
import SellerPurchaseRequest from './components/Seller/SellerPurchaseRequest.vue'
import SellerTransactions from './components/Seller/SellerTransactions.vue'
import SellerAnnouncements from './components/Seller/SellerAnnouncements.vue'
import SellerTransactionLogs from './components/Seller/SellerTransactionLogs.vue'
import SellerProductReviews from './components/Seller/SellerProductReviews.vue'
import Userdashboard from './components/Users/Userdashboard.vue'
import UserProductDetails from './components/Users/UserProductDetails.vue'
import StoreRegistration from './components/Users/StoreRegistration.vue'

Vue.use(VueRouter)


// routes 
const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Home,
            meta: {
                forVisitors: true
            }
        },
        {
            path: '/login',
            component: Login,
            meta: {
                forVisitors: true
            }
        },
        {
            path: '/register',
            component: Register,
            meta: {
                forVisitors: true
            }
        },
        {
            path: '/userdashboard',
            component: Userdashboard,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: true, sellerAuth:false
            }
        },
        {
            path: '/user_productDetails/:id',
            component: UserProductDetails,
            name: 'product_details',
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: true, sellerAuth: false
            }
        },
        {
            path: '/store_registration',
            component: StoreRegistration,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: true, sellerAuth:false
            }
        },
        {
            path: '/admin_profile',
            component: AdminProfile,
            meta: {
                requiresAuth: true, adminAuth: true, userAuth: false, sellerAuth: false
            }
        },
        {
            path: '/admindashboard',
            component: Admindashboard,
            meta: {
                requiresAuth: true, adminAuth: true, userAuth: false, sellerAuth: false
            }
        },
        {
            path: '/admin_user_list',
            component: AdminUserList,
            meta: {
                requiresAuth: true, adminAuth: true, userAuth: false, sellerAuth: false
            }
        },
        {
            path: '/admin_store_list',
            component: AdminStoreList,
            meta: {
                requiresAuth: true, adminAuth: true, userAuth: false, sellerAuth: false
            }
        },
        {
            path: '/admin_store_requests',
            component: AdminStoreRequests,
            meta: {
                requiresAuth: true, adminAuth: true, userAuth: false, sellerAuth: false
            }
        },
        {
            path: '/sellerdashboard',
            component: Sellerdashboard,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: false, sellerAuth: true
            }
        },
        {
            path: '/seller_inventory',
            component: SellerInventory,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: false, sellerAuth: true
            }
        },
        {
            path: '/seller_purchase_request',
            component: SellerPurchaseRequest,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: false, sellerAuth: true
            }
        },
        {
            path: '/seller_transactions',
            component: SellerTransactions,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: false, sellerAuth: true
            }
        },
        {
            path: '/seller_announcements',
            component: SellerAnnouncements,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: false, sellerAuth: true
            }
        },
        {
            path: '/seller_transaction_logs',
            component: SellerTransactionLogs,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: false, sellerAuth: true
            }
        },
        {
            path: '/seller_product_reviews',
            component: SellerProductReviews,
            meta: {
                requiresAuth: true, adminAuth: false, userAuth: false, sellerAuth: true
            }
        }
    ]
})

// beforeEach MIDDLEWARE
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        const token = window.localStorage.getItem('token')
        if (!token) {
            next('/login')
        }
        else if (to.meta.adminAuth) {
            const usertype = window.localStorage.getItem('usertype')
            if (usertype == 'admin') {
                next()
            }
            else if (usertype == 'user') {
                next('/userdashboard')
            }
            else { 
                next('/sellerdashboard')
            }
        }
        else if (to.meta.userAuth) { 
            const usertype = window.localStorage.getItem('usertype')
            if (usertype == 'user') {
                next()
            }
            else if (usertype == 'admin') {
                next('/admindashboard')
            }
            else { 
                next('/sellerdashboard')
            }
        }
        else if (to.meta.sellerAuth) { 
            const usertype = window.localStorage.getItem('usertype')
            if (usertype == 'seller') {
                next()
            }
            else if (usertype == 'admin') {
                next('/admindashboard')
            }
            else { 
                next('/userdashboard')
            }
        }
    }
    else if (to.meta.forVisitors) { 
        const token = window.localStorage.getItem('token')
        if (token) {
            const usertype = window.localStorage.getItem('usertype')
            if (usertype == 'admin') {
                next('/admindashboard')
            }
            else if (usertype == 'seller') { 
                next('/sellerdashboard')
            }
            else { 
                next('/userdashboard')
            }
        }
        else { 
            next()
        }
    }
    else { 
        next()
    }
})

export default router