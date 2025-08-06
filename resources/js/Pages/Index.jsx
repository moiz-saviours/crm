import React from 'react'
import MainLayout from "../Layouts/MainLayout.jsx";
import Board from "../Pages/Board.jsx";
import BoardList from "../Pages/BoardList.jsx";
import { Head } from '@inertiajs/react';

const Index = () => {
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
