import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import {AuthProvider } from './contexts/AuthContext.tsx';
import { UIProvider } from './contexts/UIContext.tsx';
import './index.css';


ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <UIProvider>
      <AuthProvider>
        <App />
      </AuthProvider>
    </UIProvider>
  </React.StrictMode>
);