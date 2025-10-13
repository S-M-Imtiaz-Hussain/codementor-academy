import React, { createContext, useContext, useState, ReactNode } from 'react';
import api from '../services/api';
import { useUI } from './UIContext';

type User = {id:number; name:string, email:string};

type AuthContextType = {
    user: User | null;
    login: (email: string, password: string) => Promise<void>;
    register: (name: string, email: string, password: string) => Promise<void>;
    logout: () => Promise<void>;
};

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function useAuth() {
    const context = useContext(AuthContext);
    if(!context) {
        throw new Error('useAuth must be in AuthProvider');
    }
    return context;
}

export function AuthProvider ({children}: {children: ReactNode}) {
    const [user, setUser] = useState<User | null>(null);
    const {setLoading, setError, clearError } = useUI();
    

    async function login(email: string, password: string) {
        setLoading(true);
        clearError();
        
        try{
            const {data} = await api.post('/login', {email, password});
            localStorage.setItem('auth_token', data.token);
            setUser(data.user);
        } catch(error: any) {
            setError(
                error.response?.status === 401 ? 'Invalid credentials': 'Login failed. Please try again.'
            );
            throw error;
        } finally { 
            setLoading(false);
        }
    }

    async function register(name:string, email: string, password: string) {
        setLoading(true);
        clearError();
        try {
            const {data} = await api.post('/register', {name, email, password});
            localStorage.setItem('auth_token', data.token);
            setUser(data.user);
        } catch (error: any) {
            const msg = error.response?.status === 422? Object.values(error.response.data.errors).flat().join(' '): 'Registration Failed.';
            setError(msg);
            throw error;
        } finally {
            setLoading(false);
        }
    }
    
    async function logout() {
        clearError();
        setLoading(true);
        try{
            await api.post('/logout');
        } catch{ } 
        finally {
            localStorage.removeItem('auth_token');
            setUser(null);
            setLoading(false);
        }
    }




    return (
        <AuthContext.Provider value={{ user, login, register, logout}}>
            {children}
        </AuthContext.Provider>
    );
}