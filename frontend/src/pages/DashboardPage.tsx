import React from 'react';
import { useAuth } from '../contexts/AuthContext.tsx';
import Card from '../components/Card.tsx';
import Button from '../components/Button.tsx';

function DashboardPage() {
    const {user, logout} = useAuth();

    function handleLogout() {
        logout();
    }


    return (
        <div className="min-h-screen bg-gray-50 p-4">
            <div className="max-w-4xl mx-auto">
                <div className="mb-6">
                    <h1 className="text-3xl font-bold text-gray-900">
                        Welcome back, {user?.name}
                    </h1>
                    <p className="text-gray-600">Email: {user?.email}</p>
                </div>

                <div className="grid md:grid-cols-2 gap-6 mb-6">
                    <Card title="My Profile">
                        <p className="text-gray-600 mb-4">
                            Manage your account settings and preferences.
                        </p>
                        <Button variant="primary">Edit Profile</Button>
                    </Card>

                    <Card title="Recent Activity">
                        <p className="text-gray-600 mb-4">
                            View your recent actions and updates.
                        </p>
                        <Button variant="secondary"> View Activity</Button>
                    </Card>
                </div>

                <Card>
                    <div className="flex items-center justify-between">
                        <div>
                            <h3 className="font-semibold">Account Settings</h3>
                            <p className="text-gray-600 text-sm">
                                Manage your account or sign out.
                            </p>
                        </div>
                        <Button variant="secondary" onClick={handleLogout}>Logout</Button>
                    </div>
                </Card>
            </div>
        </div>
    );
}

export default DashboardPage;