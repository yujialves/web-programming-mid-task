<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: http://localhost/06/", true, 301);
    exit();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="index.js" defer></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="app">
        <div v-show="showAddModal" class="modal-container">
            <div class="modal">
                <label for="begin" class="input-title">開始日時</label>
                <input v-model="begin" type="datetime-local" name="begin" id="begin" class="modal-input time-input">
                <label for="end" class="input-title">終了日時</label>
                <input v-model="end" type="datetime-local" name="end" id="end" class="modal-input time-input">
                <label for="place" class="input-title">場所</label>
                <textarea v-model="place" name="place" id="place" cols="30" rows="5" class="modal-input textarea"></textarea>
                <label for="content" class="input-title">内容</label>
                <textarea v-model="content" name="content" id="content" cols="90" rows="5" class="modal-input textarea"></textarea>
                <div class="modal-footer">
                    <label for="cancel-register-btn" class="btn">キャンセル</label>
                    <button hidden id="cancel-register-btn" @click="cancel()"></button>
                    <label for="register-btn" class="btn">登録</label>
                    <button @click="register" hidden id="register-btn"></button>
                </div>
            </div>
        </div>
        <div v-show="showEditModal" class="modal-container">
            <div class="modal">
                <label for="begin" class="input-title">開始日時</label>
                <input v-model="begin" type="datetime-local" name="begin" id="begin" class="modal-input time-input">
                <label for="end" class="input-title">終了日時</label>
                <input v-model="end" type="datetime-local" name="end" id="end" class="modal-input time-input">
                <label for="place" class="input-title">場所</label>
                <textarea v-model="place" name="place" id="place" cols="30" rows="5" class="modal-input textarea"></textarea>
                <label for="content" class="input-title">内容</label>
                <textarea v-model="content" name="content" id="content" cols="90" rows="5" class="modal-input textarea"></textarea>
                <div class="modal-footer">
                    <label for="cancel-update-btn" class="btn">キャンセル</label>
                    <button hidden id="cancel-update-btn" @click="cancel()"></button>
                    <label for="update-btn" class="btn">更新</label>
                    <button @click="update()" hidden id="update-btn"></button>
                </div>
            </div>
        </div>
        <header class="header">
            <h1 class="header-title">スケジュール一覧</h1>
            <label for="add" class="btn">追加</label>
            <button id="add" hidden @click="showAddModal = true"></button>
        </header>
        <table>
            <thead>
                <tr>
                    <th class="date">開始日時</th>
                    <th class="date">終了日時</th>
                    <th>場所</th>
                    <th>内容</th>
                    <th>更新</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="schedule in schedules" key="schedule.id">
                    <td class="date">{{schedule.begin}}</td>
                    <td class="date">{{schedule.end}}</td>
                    <td>{{schedule.place}}</td>
                    <td>{{schedule.content}}</td>
                    <td class="narrow-td">
                        <label :for="schedule.updateBtnId" class="btn">更新</label>
                        <button hidden :id="schedule.updateBtnId" @click="editSchedule(schedule)"></button>
                    </td>
                    <td class="narrow-td">
                        <label :for="schedule.removeBtnId" class="btn">削除</label>
                        <button hidden :id="schedule.removeBtnId" @click="remove(schedule.id)"></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>