import React, { createContext , useContext, useState, ReactNode } from 'react';
import api from '../services/api';


type User = {id:number; name:string; email:string};

type AuthContextType = {
    user: User | null;
    login: (email:string, password:string) => Promise<void>;
    logout:()=>void;
};

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function useAuth() {
    const context = useContext(AuthContext);
    if(!context) {
        throw new Error ('useAuth must be used within an AuthProvider');
    }
    return context;
}

export function AuthProvider({children} : {children: ReactNode}){
    const [user, setUser] = useState<user | null>(null);

    async function Login(email:string, password: string){
        const response = await api.post('/login', {email, password});
        setUser(response.data.user);
    }

    function logout() {
        setUser(null);
    }

    return (
        <AuthContext.Provider value={{user, login, logout}}>
            {children}
        </AuthContext.Provider>
    )
}


