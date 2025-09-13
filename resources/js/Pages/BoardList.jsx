import React, {useState, useRef, useEffect} from 'react';
import BoardCard from '../Pages/BoardCard.jsx';
import {Sortable} from 'sortablejs';

const BoardList = () => {
    const [isAddingCard, setIsAddingCard] = useState(null);
    const [columns, setColumns] = useState({
        done: [
            {id: 1, title: "Card 1"},
            {id: 2, title: "Card 2"},
            {id: 4, title: "Card 4"},
            {id: 5, title: "Card 5"},
            {id: 6, title: "Card 6"},
            {id: 7, title: "Card 7"},
        ],
        todo: [
            {id: 3, title: "Card 3"},
            {id: 8, title: "Card 8"},
            {id: 9, title: "Card 9"},
            {id: 10, title: "Card 10"},
        ],
        inProgress: []
    });

    const doneRef = useRef(null);
    const todoRef = useRef(null);
    const inProgressRef = useRef(null);

    useEffect(() => {
        const initializeSortable = (ref, columnId) => {
            if (!ref.current) return;

            new Sortable(ref.current, {
                group: 'shared',
                animation: 150,
                ghostClass: 'sortable-ghost',
                fallbackOnBody: true,
                swapThreshold: 0.65,
                forceFallback: true,
                onEnd: (evt) => {
                    const {from, to, oldIndex, newIndex} = evt;
                    const fromColumn = from.id;
                    const toColumn = to.id;

                    if (!fromColumn || !toColumn || oldIndex === undefined || newIndex === undefined) return;

                    setColumns(prev => {
                        const newColumns = {...prev};
                        const movedItem = newColumns[fromColumn][oldIndex];

                        // Remove from old column
                        newColumns[fromColumn] = [...newColumns[fromColumn]];
                        newColumns[fromColumn].splice(oldIndex, 1);

                        // Add to new column
                        newColumns[toColumn] = [...newColumns[toColumn]];
                        newColumns[toColumn].splice(newIndex, 0, movedItem);

                        return newColumns;
                    });

                    // Revert DOM change, React will re-render correctly
                    evt.from.insertBefore(evt.item, evt.from.children[oldIndex]);
                }
            });
        };

        initializeSortable(doneRef, 'done');
        initializeSortable(todoRef, 'todo');
        initializeSortable(inProgressRef, 'inProgress');

        return () => {
            [doneRef, todoRef, inProgressRef].forEach(ref => {
                if (ref.current?.sortable) {
                    ref.current.sortable.destroy();
                }
            });
        };
    }, []);

    const handleAddClick = (columnId) => setIsAddingCard(columnId);
    const handleClose = () => setIsAddingCard(null);

    return (
        <div className="board-position">
            <div className="board-wrapper">
                <div className="board-container">
                    {/* Done Column */}
                    <div className="board-column">
                        <div className="column-header">
                            <span className="column-title">Done</span>
                            <span className="column-menu">
                                <i className="fa-solid fa-ellipsis"></i>
                            </span>
                        </div>
                        <div className="column-body-wrapper">
                            <div className="column-body" id="done" ref={doneRef}>
                                {columns.done.map(card => (
                                    <BoardCard key={card.id} card={card}/>
                                ))}
                                {isAddingCard === 'done' && (
                                    <div className="card-input-container">
                                        <textarea className="card-input" placeholder="Enter card title..."/>
                                        <div className="card-input-actions">
                                            <button className="add-card-btn">Add Card</button>
                                            <button className="close-card-btn" onClick={handleClose}>
                                                <i className="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                )}
                            </div>
                            {isAddingCard !== 'done' && (
                                <div className="column-footer">
                                    <div className="add-card-div" onClick={() => handleAddClick('done')}>
                                        <span className="add-icon">
                                            <i className="fa-solid fa-plus"></i>
                                        </span>
                                        <span className="add-title">Add a card</span>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Todo Column */}
                    <div className="board-column">
                        <div className="column-header">
                            <span className="column-title">Todo</span>
                            <span className="column-menu">
                                <i className="fa-solid fa-ellipsis"></i>
                            </span>
                        </div>
                        <div className="column-body-wrapper">
                            <div className="column-body" id="todo" ref={todoRef}>
                                {columns.todo.map(card => (
                                    <BoardCard key={card.id} card={card}/>
                                ))}
                                {isAddingCard === 'todo' && (
                                    <div className="card-input-container">
                                        <textarea className="card-input" placeholder="Enter card title..."/>
                                        <div className="card-input-actions">
                                            <button className="add-card-btn">Add Card</button>
                                            <button className="close-card-btn" onClick={handleClose}>
                                                <i className="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                )}
                            </div>
                            {isAddingCard !== 'todo' && (
                                <div className="column-footer">
                                    <div className="add-card-div" onClick={() => handleAddClick('todo')}>
                                        <span className="add-icon">
                                            <i className="fa-solid fa-plus"></i>
                                        </span>
                                        <span className="add-title">Add a card</span>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* In Progress Column */}
                    <div className="board-column">
                        <div className="column-header">
                            <span className="column-title">In Progress</span>
                            <span className="column-menu">
                                <i className="fa-solid fa-ellipsis"></i>
                            </span>
                        </div>
                        <div className="column-body-wrapper">
                            <div className="column-body" id="inProgress" ref={inProgressRef}>
                                {columns.inProgress.map(card => (
                                    <BoardCard key={card.id} card={card}/>
                                ))}
                                {isAddingCard === 'inProgress' && (
                                    <div className="card-input-container">
                                        <textarea className="card-input" placeholder="Enter card title..."/>
                                        <div className="card-input-actions">
                                            <button className="add-card-btn">Add Card</button>
                                            <button className="close-card-btn" onClick={handleClose}>
                                                <i className="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                )}
                            </div>
                            {isAddingCard !== 'inProgress' && (
                                <div className="column-footer">
                                    <div className="add-card-div" onClick={() => handleAddClick('inProgress')}>
                                        <span className="add-icon">
                                            <i className="fa-solid fa-plus"></i>
                                        </span>
                                        <span className="add-title">Add a card</span>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default BoardList;
