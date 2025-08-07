    import React, {useEffect} from 'react'
    import MainLayout from "../Layouts/MainLayout.jsx";
    import Board from "../Pages/Board.jsx";
    import BoardList from "../Pages/BoardList.jsx";
    import { Head } from '@inertiajs/react';

    const Index = () => {
        useEffect(() => {
            window.addEventListener('error', (e) => {
                if (e.message.includes('backdrop')) {
                    console.warn('Bootstrap modal error caught');
                    e.preventDefault();
                }
            });

            return () => {
                window.removeEventListener('error', this.handleModalError);
            };
        }, []);
        return (
            <>
                <Head title="Task Management"/>
                <MainLayout>
                    <Board/>
                    <BoardList/>
                </MainLayout>
            </>
        )
    }
    export default Index
