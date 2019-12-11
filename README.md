# Validation Playground

The point of this playground was to try to make model validation better in every way. I'm using laravel doctrine in this project, because I find that the data mapper structure of Doctrine feels more "correct". Because now entities are really just plain old php objects and their only responsibility is to keep their integrity.

So I wanted to create a very simple, easy to read, api which you can use to ensure a model's integrity. For example, in [`app/Entities/Thread` at line 78](https://github.com/Evertt/validation-playground/blob/master/app/Entities/Thread.php#L78) I have the following code:

```php
protected function setTitle(string $title)
{
    validate($title, 'min:3|max:255');
    
    $this->title = $title;
    
    return $this;
}
```

If `$title` does not conform to the validation rules it throws an exception. But there's actually some magic happening here, because the exception thrown will actually _know_ that the name of the variable being tested was `title`, which it will use to make the error description clearer.

But of course, if someone fills in an entire form and makes multiple validation errors, you don't just want to throw an exception at the first field that fails validation. Therefor I wrote some more magic code. In my `ThreadController` there's a line that goes like this:

```php
$this->threadsRepo->update($thread, $request->all());
```

This `update` function will update all the properties on `$thread` with the data from `$request` using all the setter methods and therefor going through all the validation. However, if any of the validation methods throw an exception, it will just store that exception and continue on. And only after having gone through all the properties, if it sees it has one or more validation exceptions stored in its temporary storage, it will combine them all into one big validation exception that gets thrown back to the user. (In the form of redirecting to the form and showing the errors on the form of course.)

I find this a beautiful way of both ensuring that your models are valid at all times _and_ being able to write super clean and concise code.
