import React from 'react';


type ButtonProps = {
  children: React.ReactNode;
  variant?: 'primary' | 'secondary';
} & React.ButtonHTMLAttributes<HTMLButtonElement>;  

function Button({children, variant = 'primary', className='' , ...props} : ButtonProps) {
    const baseStyles = "px-4 py-2 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2";

    let variantStyles = "";

    if(variant === 'primary') {
        variantStyles = "bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500";
    } else if (variant === 'secondary') {
        variantStyles = "bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500";  
    }

    const finalStyles = '${baseStyles} ${variantStyles} ${className}';

    return (
        <button className = {finalStyles} {...props}>
            {children}
        </button>
    )
}


export default Button;