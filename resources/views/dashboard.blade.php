<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persian Learning Backend Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        h1 {
            color: #1e90ff;
        }
        .section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #1e90ff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .api-link {
            display: inline-block;
            padding: 8px 16px;
            background: #1e90ff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
        }
        .api-link:hover {
            background: #1873cc;
        }
        .count {
            font-size: 24px;
            font-weight: bold;
            color: #1e90ff;
        }
    </style>
</head>
<body>
    <h1>🎓 Persian Learning Backend Dashboard</h1>
    
    <div class="section">
        <h2>📊 Database Statistics</h2>
        <p><span class="count">{{ $stats['users'] }}</span> Users</p>
        <p><span class="count">{{ $stats['categories'] }}</span> Categories</p>
        <p><span class="count">{{ $stats['words'] }}</span> Words</p>
        <p><span class="count">{{ $stats['parent_audio'] }}</span> Parent Audio Files</p>
        <p><span class="count">{{ $stats['parent_sentences'] }}</span> Parent Sentences</p>
    </div>

    <div class="section">
        <h2>🔗 API Endpoints</h2>
        <a href="/api/test" class="api-link" target="_blank">Test API</a>
        <a href="/api/categories" class="api-link" target="_blank">Categories</a>
        <a href="/api/categories/fruits/words" class="api-link" target="_blank">Fruits Words</a>
        <a href="/api/audio/word/1" class="api-link" target="_blank">Word Audio</a>
    </div>

    <div class="section">
        <h2>👥 Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Parent ID</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->parent_id ?? '-' }}</td>
                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>📚 Categories</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Persian Name</th>
                    <th>Description</th>
                    <th>Words Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->persian_name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->words->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>🎙️ Parent Audio Files</h2>
        @if($parent_audios->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Parent</th>
                    <th>Word</th>
                    <th>Difficulty</th>
                    <th>File</th>
                    <th>Duration</th>
                    <th>Audio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parent_audios as $audio)
                <tr>
                    <td>{{ $audio->id }}</td>
                    <td>{{ $audio->parent->name ?? 'N/A' }}</td>
                    <td>{{ $audio->word->english_word ?? 'N/A' }}</td>
                    <td>{{ $audio->difficulty }}</td>
                    <td>{{ $audio->audio_file_name }}</td>
                    <td>{{ $audio->duration_seconds }}s</td>
                    <td><a href="/api/audio/file/{{ $audio->audio_file_name }}" target="_blank">Play</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No parent audio files yet.</p>
        @endif
    </div>

    <div class="section">
        <h2>📝 Parent Sentences</h2>
        @if($parent_sentences->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Parent</th>
                    <th>Word</th>
                    <th>Difficulty</th>
                    <th>Sentence</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parent_sentences as $sentence)
                <tr>
                    <td>{{ $sentence->id }}</td>
                    <td>{{ $sentence->parent->name ?? 'N/A' }}</td>
                    <td>{{ $sentence->word->english_word ?? 'N/A' }}</td>
                    <td>{{ $sentence->difficulty }}</td>
                    <td>{{ $sentence->custom_sentence }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No parent sentences yet.</p>
        @endif
    </div>

    <div class="section">
        <h2>📖 Sample Words (First 10)</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>English</th>
                    <th>Persian</th>
                    <th>Emoji</th>
                </tr>
            </thead>
            <tbody>
                @foreach($words as $word)
                <tr>
                    <td>{{ $word->id }}</td>
                    <td>{{ $word->category->name ?? 'N/A' }}</td>
                    <td>{{ $word->english_word }}</td>
                    <td>{{ $word->persian_word }}</td>
                    <td>{{ $word->emoji }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

