import React,{ createContext, useContext, useState, ReactNode } from 'react';

type UIContextType = {
    loading: boolean;
    setLoading: (val: boolean) => void;
    error: string;
    setError: (message: string) => void;
    clearError: () => void;
};


const UIContext = createContext<UIContextType | undefined>(undefined);

export function useUI() {
    const context = useContext(UIContext);
    if(!context) {
        throw new Error('useUI must be used withing UIProvider');
    }
    return context;
}


export function UIProvider({children} : {children: ReactNode}) {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');

    function clearError() {
        setError('');
    }

    return (
        <UIContext.Provider  value={{loading, setLoading, error, setError, clearError}}>
            {children}
        </UIContext.Provider>
    );
}