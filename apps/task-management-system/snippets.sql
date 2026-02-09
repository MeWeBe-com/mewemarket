<<<<<<< HEAD
//manage Task - to be extended

=======
>>>>>>> d6698e366649ff67935ee34cd2bf89c1c2622c1a
SELECT task.TASK_ID, task.TASK_TITLE , task.TASK_AMOUNT, task.TASK_AMOUNT_ASSIGNED, task.TASK_AMOUNT_DONE, GROUP_CONCAT(assigned_to ORDER BY assigned_to ASC SEPARATOR ', ') AS PEOPLE_ASSIGNED
FROM task_assignment
INNER JOIN task
ON task_assignment.TASK_ID = task.TASK_ID
GROUP BY task_assignment.TASK_ID
