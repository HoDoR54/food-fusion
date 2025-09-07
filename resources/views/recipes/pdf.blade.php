<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $recipe->name }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 30px;
            color: #121212;
        }
        h1 { 
            color: #2e1c57;
            font-size: 24px;
        }
        h2 {
            color: #2e1c57;
            font-size: 18px;
            border-bottom: 1px solid #999999;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
            text-align: center;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 5px;
        }
        .step {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>{{ $recipe->name }}</h1>
    
    <p><strong>By:</strong> {{ $recipe->author_name }}</p>
    
    @if($recipe->description)
        <p>{{ $recipe->description }}</p>
    @endif

    <p>
        <strong>Tags:</strong>
        @foreach($recipe->tags as $tag)
            {{ $tag->name }},
        @endforeach
        {{ $recipe->difficulty->label() }}
    </p>

    <table border="1" style="margin: 20px 0; background: white;">
        <tr>
            <td><strong>Servings</strong><br>{{ $recipe->servings ?? 'N/A' }}</td>
            <td><strong>Prep Time</strong><br>{{ $recipe->getPreparationMinutes() }} min</td>
            <td><strong>Cook Time</strong><br>{{ $recipe->getTotalCookingMinutes() }} min</td>
            <td><strong>Total Time</strong><br>{{ $recipe->getTotalMinutes() }} min</td>
        </tr>
    </table>

    <h2>Ingredients</h2>
    <ul>
        @forelse($recipe->ingredient_list as $ingredient)
            <li>{{ $ingredient }}</li>
        @empty
            <li>No ingredients listed</li>
        @endforelse
    </ul>

    <h2>Instructions</h2>
    @forelse($recipe->steps->sortBy('order') as $step)
        <div class="step">
            <p><strong>{{ $step->order }}. {{ $step->stepType->label() }}</strong>
            @if($step->estimated_minutes_taken > 0)
                ({{ $step->estimated_minutes_taken }} min)
            @endif
            </p>
            <p>{{ $step->description }}</p>
        </div>
    @empty
        <p>No instructions available</p>
    @endforelse

    <hr>
    <p style="text-align: center; font-size: 12px; color: #666666;">
        FoodFusion Recipe • {{ now()->format('M j, Y') }}
    </p>
</body>
</html>
