import Login from './Login';
import Register from './Register';
import Verify from './Verify';
import Profile from './Profile';

export default [
  {path: '/login', name: 'Login', component: Login},
  {path: '/register', name: 'Register', component: Register},
  { path: '/verify/:email/:token', name: 'verify', component: Verify },
  { path: '/profile', name: 'Profile', component: Profile },
]
