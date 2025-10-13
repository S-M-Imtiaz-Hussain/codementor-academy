import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import HomePage from './pages/HomePage.tsx';
import LoginPage from './pages/LoginPage.tsx';
import RegisterPage from './pages/RegiserPage.tsx';
import DashboardPage from './pages/DashboardPage.tsx';
import ProfilePage from './pages/ProfilePage.tsx';
import PrivateRoute from './components/PrivateRoute.tsx';
import {useUI} from './contexts/UIContext';
// import reactLogo from './assets/react.svg'
// import viteLogo from '/vite.svg'
// import './App.css'



// function App() {
//   return (
//     <BrowserRouter>
//       <Routes>
//         <Route path="/" element={<HomePage />} />
//         <Route path="/login" element={<LoginPage />} />
//         <Route path="/register" element={<RegisterPage />} />
//         <Route path="/dashboard" 
//           element={
//             <PrivateRoute>
//               <DashboardPage />
//             </PrivateRoute>
//           } />
//         <Route path="/profile" 
//           element={
//             <PrivateRoute>
//               <ProfilePage />
//             </PrivateRoute>
//             } />
//       </Routes>
//     </BrowserRouter>
//   );
// }

function App() {
  const { loading, error, clearError } = useUI();
  return (
    <BrowserRouter>
      {loading && (
        <div className='fixex inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50'>
          <div className='loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-16 w-16'>

          </div>
        </div>
      )}

      {error && (
        <div className='fixed top-4 left-1/2 transform-translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded shadow z-50'>
          <span> {error}</span>
          <button className="ml-4 font-bold" onClick={clearError}>
            x
          </button>
        </div>
      )}

      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />
        <Route path="/dashboard"
          element={
            <PrivateRoute>
              <DashboardPage />
            </PrivateRoute>
          } />
        <Route path="/profile"
          element={
            <PrivateRoute>
              <ProfilePage />
            </PrivateRoute>
          } />  
      </Routes>
    </BrowserRouter>
  );
}


export default App



