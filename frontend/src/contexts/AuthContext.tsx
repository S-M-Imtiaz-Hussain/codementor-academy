import React, { createContext , useContext, useState, ReactNode } from 'react';
import api from '../services/api';
import { useUI } from './UIContext';


type User = {id:number; name:string; email:string};

type AuthContextType = {
    user: User | null;
    login: (email:string, password:string) => Promise<void>;
    register: (name:string, email:string, password:string) => Promise<void>;
    logout:()=>void;
    loading: boolean;
};

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function useAuth() {
    const context = useContext(AuthContext);
    if(!context) {
        throw new Error ('useAuth must be used within an AuthProvider');
    }
    return context;
}

export function AuthProvider({children} : {children: ReactNode}) {
    const [user, setUser] = useState<User | null>(null);
    // const [loading, setLoading] = useState(false);
    const [setLoading, setError, clearError] = useUI();

    async function login(email:string, password: string){
        setLoading(true);
        
        try {
            const response = await api.post('login', {
                email: email,
                password: password
            });
            const { user:userData, token} = response.data;
            localStorage.setItem('auth_token', token);
            setUser(userData);
            console.log('login successful', userData);
        }
        catch(error: any) {
            // console.log('Login error: ',error);
            setError(
                error.response?.status ===  401
                    ? 'Invalid Credentials'
                    : 'Login Failed. Please Try Again'
            );
            throw error;

            // if(error.response?.status === 401) {
            //     throw new Error('Invalid email or password');
            // } else if (error.response?.status >= 500) {
            //     throw new Error('Server error. Please try again later.');
            // } else {
            //     throw new Error('Login failed. Please try again.');
            // }
        }
        finally {
            setLoading(false);
        }
    }

    async function register(name: string, email: string, password: string) {
        setLoading(true);

        try{
            const response = await api.post('/register', {
                name: name,
                email: email,
                password: password
            });

            const {user : userData, token } = response.data;

            localStorage.setItem('auth_token', token);
            setUser(userData);
            console.log('Registration Successfull', userData);
        }
        catch(error: any) {
            // console.error('Registration error: ', error);

            // if(error.response?.status === 422) {
            //     const validationErrors = error.response.data.errors;
            //     throw new Error(Object.values(validationErrors).flat().join(' '));
            // }
            const msg = error.response?.status === 422
                ? Object.values(error.respojnse.data.errors).flat().join(' ')
                : 'Registration Failed.';
            
            setError(msg);
            throw error;
        }
        finally {
            setLoading(false);
        }
    }

    async function logout() {
        // try {
        //     await api.post('/logout');
        // } catch (error) {
        //     console.error('Logout.error: ',error);
        // }
        // finally {
        //     localStorage.removeItem('auth_token');
        //     setUser(null);
        //     console.log('User logged out!');
        // }
        clearError();
        setLoading(true);
        try {
            await api.post('/logout');
        } catch {}
        finally {
            localStorage.removeItem('auth_token');
            setUser(null);
            setLoading(false);
        }
    }

    return (
        <AuthContext.Provider value={{user,login, logout, register, loading}}>
            {children}
        </AuthContext.Provider>
    );
}