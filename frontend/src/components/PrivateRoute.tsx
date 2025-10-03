import React from 'react';
import { Navigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext.tsx';

type PrivateRouteProps = {
    children: React.ReactNode;
}

function PrivateRoute ({children }: PrivateRouteProps){
    const {user} = useAuth();

    return user ? <>{children}</> : <Navigate to="/login" replace />;
}

export default PrivateRoute;