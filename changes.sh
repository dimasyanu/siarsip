commit_id=$1
# out=$( git show -s $commit_id --format=%cd --date=iso )
filename=$2
# filename="$out.zip"

# if grep -q "poet" $file_name
# then
#     echo "poet was found in $file_name"
# fi

# a=1
# while grep -q "poet" $file_name
# do
#    echo $a
#    a=`expr $a + 1`
# done

# echo $filename
git diff-tree -r --no-commit-id --name-only --diff-filter=ACMRT $commit_id | xargs tar -rf $filename