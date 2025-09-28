import React from 'react';


type CardProps = {
    children : React.ReactNode;
    title ?: string;
} & React.HTMLAttributes<HTMLDivElement>;


function Card ({children, title, className = '', ...props } : cardProps) {

    const baseStyles = "bg-white border rounded-lg shadow-sm p-6";
    const finalStyles = '${baseStyles} ${className}';

    return (
        <div className ={finalStyles} {...props}>
            {title && (<h3 className="text-lg font-semibold mb-4">
                {title}
            </h3>
            )}

            {children}

        </div>
    );
}

export default Card;
